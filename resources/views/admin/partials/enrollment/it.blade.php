
    <div class="col-lg-8">
        <div class="form-group">
            <label>UserId *</label>
            <input id="user_name" name="user_name" type="text" class="form-control required" value="{{ $initial_user_name ? $initial_user_name : $candidate->name }}">
        </div>
        <div class="form-group">
            <label>Email *</label>
            <input id="email" name="email" type="text" class="form-control form-control-sm required email" value="{{ $initial_user_email }}">
        </div>

        <div class="form-group">
            <label>Password *</label>
            <input id="password" name="password" type="password" class="form-control form-control-sm required" value="">

        </div>
    </div>

    <div class="col-lg-4">
        <div class="text-center">
            <div style="margin-top: 20px">
                <i class="fa fa-sign-in" style="font-size: 180px;color: #e5e5e5 "></i>
            </div>
        </div>
    </div>

