@extends('admin.layouts.default')

@section('title')
Correlative
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/iCheck/blue.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/iCheck/orange.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
<style>
#page-wrapper {
	background: #fff !important;
}

.form-check-label {
	padding-left: 6px;
}

table.dataTable {
	table-layout: fixed;
}

#relation-map {
	position: relative;
	color: #4F4F4F;
	margin-left: -30px;
}

.graph {
	position: relative;
	z-index: 1;
	width: 600px;
	height: 600px;
	display: flex;
}

.graph-column {
	flex-basis: 0;
	flex-grow: 1;
	display: flex;
	flex-direction: column;
	justify-content: space-around;
	align-items: center;
}

.first-column,
.third-column {
	box-sizing: border-box;
	display: flex;
	justify-content: center;
	text-align: left;
	align-items: center;
	width: 220px;
	height: 40px;
	padding: 6px;
	color: #4F4F4F;
	border: 1px solid #BDBDBD;
}

.first-column {
	border-top-left-radius: 10px;
	border-bottom-left-radius: 10px;
}

.task {
	background: #F3FBFE;
	border-left-color: #56CCF2;
}

.topic {
	background: rgb(255, 255, 204);
	border-left-color: #D4A514;
}

.second-column {
	box-sizing: border-box;
	display: flex;
	align-items: center;
	justify-content: flex-start;
	text-align: center;
	padding: 6px;
	width: 200px;
	height: 64px;
	border-radius: 10px;
	color: #4F4F4F;
	border: 1px solid #BDBDBD;
}

.second-column:hover,
.third-column:hover,
.first-column:hover {
	box-shadow: 5px 5px 7px rgba(33, 33, 33, 0.7);
	color: #4F4F4F;
}

.third-column {
	border-top-right-radius: 10px;
	border-bottom-right-radius: 10px;
	color: #4F4F4F;
	border-left-width: 3px;
	border-left-style: solid;
}

.Letter {
	background: #F1FCF5;
	border-right: 3px solid #2C8F7B;
}

.MOM {
	background: #FFFBF4;
	border-right: 3px solid #DE864F;
}

.Report {
	background: #EEF5FF;
	border-right: 3px solid #2389C5;
}

.svg-wrapper {
	position: absolute;
	width: 600px;
	height: 600px;
	left: 0;
	top: 0;
}

.relation-map-header {
	border-bottom: 1px solid #BDBDBD;
	height: 60px;
	padding: 8px;
	margin-bottom: 12px;
	width: 100%;
	display: flex;
	align-items: center;
	color: #828282;
}

.to {
	/* margin: 0 6px; */
	padding: 6px 10px
}

.daterange-wrapper {
	display: flex;
	width: 380px;
	/* align-items: center; */
	/* margin-left: 40px; */
}

.vertical-line {
	width: 0;
	border-right: 1px solid #828282;
	height: 16px;
	margin: 0 18px;
}

.switch,
.reset {
	width: 90px;
	border-radius: 12px;
	line-height: 24px;
	background: #52B79A;
	color: #fff;
	text-align: center;
	cursor: pointer;
}

.reset {
	margin-left: 12px;
	background: #BEBEBE;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('js/operations/listings.js') }}"></script>
<script>
var isFetchingRelationMap = false
var isConnectByTopic = true
var originData = {}
var selectedTypes = ['Report', 'MOM', 'Letter']
const theme = {
	Task: '#56CCF2',
	Report: '#2389C5',
	MOM: '#DE864F',
	Letter: '#2C8F7B',
	Topic: '#D4A514'
}

window.addEventListener("pageshow", function(event) {
	var historyTraversal = event.persisted || (typeof window.performance != "undefined" && window
		.performance.navigation.type === 2);
	if (historyTraversal) {
		window.location.reload();
	}
});

$(document).ready(function() {
	$('.input-daterange').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		autoclose: true
	});

	$('.input-daterange').datepicker().on('changeDate', function(e) {
		const startDate = $('#start_date').val()
		const endDate = $('#end_date').val()
		if (startDate && endDate) {
			fetchRelationMap()
		}
	})

	$('.switch').on('click', function() {
		isConnectByTopic = !isConnectByTopic
		isConnectByTopic ? generateGraph() : generateGraph2()
	})

	$('.reset').on('click', function() {
		$('#start_date').val("")
		$('#end_date').val("")
		fetchRelationMap()
	})

	$('.green').iCheck({
		checkboxClass: 'icheckbox_square-green'
	});
	$('.blue').iCheck({
		checkboxClass: 'icheckbox_square-blue'
	});
	$('.orange').iCheck({
		checkboxClass: 'icheckbox_square-orange'
	});

	$('.i-checks').on('ifClicked', function() {
		const arr = []
		if ($('#letter-checkbox').is(':checked') && $(this).val() !== 'Letter') {
			arr.push('Letter')
		}
		if ($('#report-checkbox').is(':checked') && $(this).val() !== 'Report') {
			arr.push('Report')
		}
		if ($('#mom-checkbox').is(':checked') && $(this).val() !== 'MOM') {
			arr.push('MOM')
		}
		if (!$(this).is(":checked")) {
			arr.push($(this).val())
		}

		selectedTypes = arr
		const entities = originData.entities.filter(item => arr.includes(item.type))

		isConnectByTopic ? generateGraph() : generateGraph2()
	})

	fetchRelationMap()
})

function generateGraph() {
	$('#first').empty()
	$('#third').empty()
	$('#second').empty()
	$('#relation-map-lines').empty()

	const tempOriginData = JSON.parse(JSON.stringify(originData))
	const entitiesSelected = tempOriginData.entities.filter(item => selectedTypes.includes(item.type))
	tempOriginData.entities = entitiesSelected

	const selectedEntityIds = tempOriginData.entities.map(item => item.unique_id)
	const currentTopics = []
	const availableEntityIds = new Set()
	const availableTaskIds = new Set()
	tempOriginData.topics.forEach(x => {
		const linkedEntityIds = x.linkedEntityIds
		const linkedTaskIds = x.linkedTaskIds
		const isAvailable = linkedEntityIds.filter(y => selectedEntityIds.includes(y)).length > 0
		if (isAvailable) {
			linkedEntityIds.forEach(unique_id => availableEntityIds.add(unique_id))
			linkedTaskIds.forEach(unique_id => availableTaskIds.add(unique_id))
			currentTopics.push({
				...x,
				linkedEntityIds: linkedEntityIds.filter(y => selectedEntityIds.includes(y)),
			})
		}
	})

	const currentTasks = tempOriginData.tasks.filter(x => availableTaskIds.has(x.unique_id))
	const currentEntities = tempOriginData.entities.filter(x => availableEntityIds.has(x.unique_id))

	const formatTopics = []
	for (let i = 0; i < tempOriginData.topics.length; i++) {
		const item = tempOriginData.topics[i]
		const linkedEntityIds = []
		const linkedTaskIds = []
		for (let j = 0; j < item.linkedEntityIds.length; j++) {
			const pos = currentEntities.findIndex(({
				unique_id
			}) => unique_id === item.linkedEntityIds[j])
			if (pos !== -1) {
				linkedEntityIds.push({
					unique_id: item.linkedEntityIds[j],
					pos
				})
			}
		}
		for (let j = 0; j < item.linkedTaskIds.length; j++) {
			const pos = currentTasks.findIndex(({
				unique_id
			}) => unique_id === item.linkedTaskIds[j])
			if (pos !== -1) {
				linkedTaskIds.push({
					unique_id: item.linkedTaskIds[j],
					pos
				})
			}
		}
		if (linkedEntityIds.length > 0) {
			formatTopics.push({
				...item,
				title: item.title,
				linkedEntityIds,
				linkedTaskIds
			})
		}
	}

	const sourceDataOfGraph = {
		entities: currentEntities,
		topics: formatTopics,
		tasks: currentTasks
	}

	const CONTAINER_WIDTH = document.body.clientWidth / 1.3;
	const FIRST_COLUMN_WIDTH = 220;
	const FIRST_COLUMN_HEIGHT = 40;
	const SECOND_COLUMN_WIDTH = 200;
	const SECOND_COLUMN_HEIGHT = 64;
	const THIRD_COLUMN_WIDTH = 220;
	const THIRD_COLUMN_HEIGHT = 40;
	const CONTAINER_HEIGHT = Math.max(FIRST_COLUMN_HEIGHT * sourceDataOfGraph.entities.length,
		SECOND_COLUMN_HEIGHT * sourceDataOfGraph
		.topics.length,
		THIRD_COLUMN_HEIGHT * sourceDataOfGraph.tasks.length) * 1.4
	$('.graph').css({
		height: CONTAINER_HEIGHT,
		width: document.body.clientWidth / 1.3
	})
	$('.svg-wrapper').css({
		height: CONTAINER_HEIGHT,
		width: document.body.clientWidth / 1.3
	})


	const lines = [];
	const linesBetweenTopicAndEntity = [];
	const linesBetweenTopicAndTask = [];
	sourceDataOfGraph.topics.forEach((item, index) => {
		item.linkedEntityIds.forEach(({
			pos,
			unique_id
		}) => {
			const currentEntity = sourceDataOfGraph.entities.find(x => x.unique_id ===
				unique_id) || {}
			linesBetweenTopicAndEntity.push([pos, index, currentEntity.type]);
		});
		item.linkedTaskIds.forEach(({
			pos
		}) => {
			linesBetweenTopicAndTask.push([index, pos, 'Task']);
		});
	});

	const FIRST_COLUMN_RIGHT_X = (CONTAINER_WIDTH / 3 - FIRST_COLUMN_WIDTH) / 2 + FIRST_COLUMN_WIDTH;
	const SECOND_COLUMN_LEFT_X = (CONTAINER_WIDTH / 3 - SECOND_COLUMN_WIDTH) / 2 + CONTAINER_WIDTH /
		3;
	const SECOND_COLUMN_RIGHT_X = (2 * CONTAINER_WIDTH) / 3 - (CONTAINER_WIDTH / 3 -
		SECOND_COLUMN_WIDTH) / 2;
	const THIRD_COLUMN_LEFT_X = (2 * CONTAINER_WIDTH) / 3 + (CONTAINER_WIDTH / 3 -
		THIRD_COLUMN_WIDTH) / 2;
	const first_column_gap = (CONTAINER_HEIGHT - sourceDataOfGraph.entities.length *
		FIRST_COLUMN_HEIGHT) / (sourceDataOfGraph.entities.length);
	const second_column_gap = (CONTAINER_HEIGHT - sourceDataOfGraph.topics.length *
		SECOND_COLUMN_HEIGHT) / (sourceDataOfGraph.topics.length);
	const third_column_gap = (CONTAINER_HEIGHT - sourceDataOfGraph.tasks.length *
		THIRD_COLUMN_HEIGHT) / (sourceDataOfGraph.tasks.length);

	linesBetweenTopicAndEntity.forEach(item => {
		lines.push([
			FIRST_COLUMN_RIGHT_X,
			FIRST_COLUMN_HEIGHT / 2 + item[0] * (FIRST_COLUMN_HEIGHT + first_column_gap) + 0.5 *
			first_column_gap,
			SECOND_COLUMN_LEFT_X,
			SECOND_COLUMN_HEIGHT / 2 + item[1] * (SECOND_COLUMN_HEIGHT + second_column_gap) +
			0.5 * second_column_gap,
			item[2]
		]);
	});

	linesBetweenTopicAndTask.forEach(item => {
		lines.push([
			SECOND_COLUMN_RIGHT_X,
			SECOND_COLUMN_HEIGHT / 2 + item[0] * (SECOND_COLUMN_HEIGHT + second_column_gap) +
			0.5 * second_column_gap,
			THIRD_COLUMN_LEFT_X,
			THIRD_COLUMN_HEIGHT / 2 + item[1] * (THIRD_COLUMN_HEIGHT + third_column_gap) + 0.5 *
			third_column_gap,
			item[2]
		]);
	});

	sourceDataOfGraph.entities.forEach(item => {
		const href = item.url
		if (item.type === 'Letter') {
			const ele = '<a class="first-column Letter" href=' + href + '>' + item.title + '</a>'
			$('#first').append(ele)
		} else if (item.type === 'MOM') {
			const ele = '<a class="first-column MOM" href=' + href + '>' + item.title + '</a>'
			$('#first').append(ele)
		} else {
			const ele = '<a class="first-column Report" href=' + href + '>' + item.title + '</a>'
			$('#first').append(ele)
		}
	})

	sourceDataOfGraph.topics.forEach(item => {
		const href = item.url
		const ele = '<a class="second-column topic" href=' + href + '>' + '#' + item.title + '</a>'
		$('#second').append(ele)
	})

	sourceDataOfGraph.tasks.forEach(item => {
		const href = item.url
		const ele = '<a class="third-column task" href=' + href + '>' + item.title + '</a>'
		$('#third').append(ele)
	})

	lines.forEach(item => {
		var NS = "http://www.w3.org/2000/svg";
		var ll = document.createElementNS(NS, "path")
		$(ll).attr({
			d: `M${item[0]},${item[1]} C${(item[0] + item[2]) / 2},${item[1]} ${(item[0] + item[2]) / 2},${item[3]} ${item[2]},${item[3]}`,
		}).css({
			"stroke": theme[item[4]],
			"fill": "none",
			"stroke-width": "1"
		});
		$('#relation-map-lines').append(ll)
	})
}

function generateGraph2() {
	$('#first').empty()
	$('#second').empty()
	$('#third').empty()
	$('#relation-map-lines').empty()

	const tempOriginData = JSON.parse(JSON.stringify(originData))
	const entitiesSelected = tempOriginData.entities.filter(item => selectedTypes.includes(item.type))
	tempOriginData.entities = entitiesSelected

	const selectedEntityIds = tempOriginData.entities.map(item => item.unique_id)
	const currentTasks = []
	const availableEntityIds = new Set()
	const availableTaskIds = new Set()
	const availableTopicIds = new Set()
	tempOriginData.tasks.forEach(x => {
		const linkedEntityIds = x.linkedEntityIds
		const linkedTopicIds = x.linkedTopicIds
		const isAvailable = linkedEntityIds.filter(y => selectedEntityIds.includes(y)).length > 0
		if (isAvailable) {
			linkedEntityIds.forEach(unique_id => availableEntityIds.add(unique_id))
			linkedTopicIds.forEach(unique_id => availableTopicIds.add(unique_id))
			currentTasks.push({
				...x,
				linkedEntityIds: linkedEntityIds.filter(y => selectedEntityIds.includes(y)),
			})
		}
	})

	const currentTopic = tempOriginData.topics.filter(x => availableTopicIds.has(x.unique_id))
	const currentEntities = tempOriginData.entities.filter(x => availableEntityIds.has(x.unique_id))

	const formatTasks = []
	for (let i = 0; i < tempOriginData.tasks.length; i++) {
		const item = tempOriginData.tasks[i]
		const linkedEntityIds = []
		// const linkedTaskIds = []
		const linkedTopicIds2 = []
		for (let j = 0; j < item.linkedEntityIds.length; j++) {
			const pos = currentEntities.findIndex(({
				unique_id
			}) => unique_id === item.linkedEntityIds[j])
			if (pos !== -1) {
				linkedEntityIds.push({
					unique_id: item.linkedEntityIds[j],
					pos
				})
			}
		}
		for (let j = 0; j < item.linkedTopicIds.length; j++) {
			const pos = currentTopic.findIndex(({
				unique_id
			}) => unique_id === item.linkedTopicIds[j])
			if (pos !== -1) {
				linkedTopicIds2.push({
					unique_id: item.linkedTopicIds[j],
					pos
				})
			}
		}
		if (linkedEntityIds.length > 0) {
			formatTasks.push({
				...item,
				title: item.title,
				linkedEntityIds,
				linkedTopicIds2
			})
		}
	}

	const sourceDataOfGraph = {
		entities: currentEntities,
		topics: currentTopic,
		tasks: formatTasks
	}

	const CONTAINER_WIDTH = document.body.clientWidth / 1.3;
	const FIRST_COLUMN_WIDTH = 220;
	const FIRST_COLUMN_HEIGHT = 40;
	const SECOND_COLUMN_WIDTH = 200;
	const SECOND_COLUMN_HEIGHT = 64;
	const THIRD_COLUMN_WIDTH = 220;
	const THIRD_COLUMN_HEIGHT = 40;
	const CONTAINER_HEIGHT = Math.max(FIRST_COLUMN_HEIGHT * sourceDataOfGraph.entities.length,
		SECOND_COLUMN_HEIGHT * sourceDataOfGraph
		.tasks.length,
		THIRD_COLUMN_HEIGHT * sourceDataOfGraph.topics.length) * 1.4
	$('.graph').css({
		height: CONTAINER_HEIGHT,
		width: document.body.clientWidth / 1.3
	})
	$('.svg-wrapper').css({
		height: CONTAINER_HEIGHT,
		width: document.body.clientWidth / 1.3
	})

	const lines = [];
	const linesBetweenTaskAndEntity = [];
	const linesBetweenTopicAndTask = [];
	sourceDataOfGraph.tasks.forEach((item, index) => {
		item.linkedEntityIds.forEach(({
			pos,
			unique_id
		}) => {
			const currentEntity = sourceDataOfGraph.entities.find(x => x.unique_id ===
				unique_id) || {}
			linesBetweenTaskAndEntity.push([pos, index, currentEntity.type]);
		});
		item.linkedTopicIds2.forEach(({
			pos
		}) => {
			linesBetweenTopicAndTask.push([index, pos, 'Topic']);
		});
	});

	const FIRST_COLUMN_RIGHT_X = (CONTAINER_WIDTH / 3 - FIRST_COLUMN_WIDTH) / 2 + FIRST_COLUMN_WIDTH;
	const SECOND_COLUMN_LEFT_X = (CONTAINER_WIDTH / 3 - SECOND_COLUMN_WIDTH) / 2 + CONTAINER_WIDTH /
		3;
	const SECOND_COLUMN_RIGHT_X = (2 * CONTAINER_WIDTH) / 3 - (CONTAINER_WIDTH / 3 -
		SECOND_COLUMN_WIDTH) / 2;
	const THIRD_COLUMN_LEFT_X = (2 * CONTAINER_WIDTH) / 3 + (CONTAINER_WIDTH / 3 -
		THIRD_COLUMN_WIDTH) / 2;
	const first_column_gap = (CONTAINER_HEIGHT - sourceDataOfGraph.entities.length *
		FIRST_COLUMN_HEIGHT) / (sourceDataOfGraph.entities.length);
	const second_column_gap = (CONTAINER_HEIGHT - sourceDataOfGraph.tasks.length *
		SECOND_COLUMN_HEIGHT) / (sourceDataOfGraph.tasks.length);
	const third_column_gap = (CONTAINER_HEIGHT - sourceDataOfGraph.topics.length *
		THIRD_COLUMN_HEIGHT) / (sourceDataOfGraph.topics.length);

	linesBetweenTaskAndEntity.forEach(item => {
		lines.push([
			FIRST_COLUMN_RIGHT_X,
			FIRST_COLUMN_HEIGHT / 2 + item[0] * (FIRST_COLUMN_HEIGHT + first_column_gap) + 0.5 *
			first_column_gap,
			SECOND_COLUMN_LEFT_X,
			SECOND_COLUMN_HEIGHT / 2 + item[1] * (SECOND_COLUMN_HEIGHT + second_column_gap) +
			0.5 * second_column_gap,
			item[2]
		]);
	});

	linesBetweenTopicAndTask.forEach(item => {
		lines.push([
			SECOND_COLUMN_RIGHT_X,
			SECOND_COLUMN_HEIGHT / 2 + item[0] * (SECOND_COLUMN_HEIGHT + second_column_gap) +
			0.5 * second_column_gap,
			THIRD_COLUMN_LEFT_X,
			THIRD_COLUMN_HEIGHT / 2 + item[1] * (THIRD_COLUMN_HEIGHT + third_column_gap) + 0.5 *
			third_column_gap,
			item[2]
		]);
	});

	sourceDataOfGraph.entities.forEach(item => {
		const href = item.url
		if (item.type === 'Letter') {
			const ele = '<a class="first-column Letter" href=' + href + '>' + item.title + '</a>'
			$('#first').append(ele)
		} else if (item.type === 'MOM') {
			const ele = '<a class="first-column MOM" href=' + href + '>' + item.title + '</a>'
			$('#first').append(ele)
		} else {
			const ele = '<a class="first-column Report" href=' + href + '>' + item.title + '</a>'
			$('#first').append(ele)
		}
	})

	sourceDataOfGraph.topics.forEach(item => {
		const href = item.url
		const ele = '<a class="third-column topic" href=' + href + '>' + '#' + item.title + '</a>'
		$('#third').append(ele)
	})

	sourceDataOfGraph.tasks.forEach(item => {
		const href = item.url
		const ele = '<a class="second-column task" href=' + href + '>' + item.title + '</a>'
		$('#second').append(ele)
	})

	lines.forEach(item => {
		var NS = "http://www.w3.org/2000/svg";
		var ll = document.createElementNS(NS, "path")
		$(ll).attr({
			d: `M${item[0]},${item[1]} C${(item[0] + item[2]) / 2},${item[1]} ${(item[0] + item[2]) / 2},${item[3]} ${item[2]},${item[3]}`,
		}).css({
			"stroke": theme[item[4]],
			"fill": "none",
			"stroke-width": "1"
		});
		$('#relation-map-lines').append(ll)
	})
}

function fetchRelationMap() {
	if (isFetchingRelationMap) {
		return
	}
	const companyId = $('#relation-map-company-id').val()
	const departmentId = $('#relation-map-department-id').val()
	const startDate = $('#start_date').val()
	const endDate = $('#end_date').val()

	let formData = new FormData()
	formData.append("company_id", companyId)
	formData.append("department_id", departmentId)
	if (startDate && endDate) {
		formData.append("start_date", moment(startDate).format('YYYY-MM-DD'))
		formData.append("end_date", moment(endDate).format('YYYY-MM-DD'))
	}

	isFetchingRelationMap = true
	$.ajax({
		url: baseUrl + '/api/correlative_map',
		type: 'POST',
		dataType: 'JSON',
		data: formData,
		processData: false,
		contentType: false,
		success: function(data) {
			if (data.code === 200) {
				originData = data.result
				isConnectByTopic ? generateGraph() : generateGraph2()
			}
			isFetchingRelationMap = false
		}
	});
}
</script>
@endsection

@section('content')
<div class="row wrapper page-heading">
	<input id="relation-map-company-id" type="hidden" name="company_id"
		value="{{ Auth::user()->company_id }}">
	<input id="relation-map-department-id" type="hidden" name="department_id"
		value="{{ Auth::user()->dept_id }}">
	<div class="col-lg-12">

		<div class='relation-map-header'>
			<div class="form-check form-check-inline">
				<i class="fas fa-filter"></i>
				<span style="margin:0 10px 0 2px">Filter By:</span>
				<input checked class="i-checks green" type="checkbox" id="letter-checkbox" value="Letter">
				<label class="form-check-label" for="letter-checkbox">Letters</label>
			</div>
			<div class="form-check form-check-inline">
				<input checked class="i-checks blue" type="checkbox" id="report-checkbox" value="Report">
				<label class="form-check-label" for="report-checkbox">Reports</label>
			</div>
			<div class="form-check form-check-inline">
				<input checked class="i-checks orange" type="checkbox" id="mom-checkbox" value="MOM">
				<label class="form-check-label" for="mom-checkbox">MOM</label>
			</div>

			<div class="vertical-line"></div>

			<div class="input-daterange input-group daterange-wrapper">
				<span style="padding:6px 10px">Date Range:</span>
				<span class="input-group-addon">
					<i class="far fa-calendar-alt"></i>
				</span>
				<input type="text" class="form-control-sm form-control text-left date" name="start_date"
					id="start_date" placeholder="start date">
				<span class="to">to</span>
				<span class="input-group-addon">
					<i class="far fa-calendar-alt"></i>
				</span>
				<input type="text" class="form-control-sm form-control text-left date" name="end_date"
					id="end_date" placeholder="end date">
			</div>

			<div class='reset'>
				<i class="fas fa-undo"></i>
				<span style="margin-left: 4px;">Reset</span>
			</div>

			<div class="vertical-line" style="margin: 0 28px"></div>

			<div class='switch'>
				<i class="fas fa-sync-alt"></i>
				<span style="margin-left: 4px;">Switch</span>
			</div>
		</div>

		<div id="relation-map">
			<div class="graph">
				<div id="first" class="graph-column"></div>
				<div id="second" class="graph-column"></div>
				<div id="third" class="graph-column"></div>
			</div>

			<div class='svg-wrapper'>
				<svg id='relation-map-lines' width="100%" height="100%">
				</svg>
			</div>
		</div>
	</div>
</div>


@endsection