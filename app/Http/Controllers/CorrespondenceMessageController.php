<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\CorrespondenceMessage;

class CorrespondenceMessageController extends Controller
{
  /**
	* Reply page
	*
	* @return View
	*/
	public function replyList()
	{
		$messages = CorrespondenceMessage::all();

		return view('admin.pages.correspondence.messages.reply_list', compact(
			'messages'
		));
	}

	/**
	* Create page
	*
	* @return View
	*/
	public function createList()
	{
		$messages = CorrespondenceMessage::all();

		return view('admin.pages.correspondence.messages.create_list', compact(
			'messages'
		));
	}

}
