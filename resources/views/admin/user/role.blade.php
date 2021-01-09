<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<form action="{{route('admin.user.role',$user)}}" method="post">
    @csrf

    @foreach($roles as $role)
        <div>
            <label for="">{{$role->name}}

                <input type="radio" name="role_id" value="{{$role->id}}"
                @if($role->id == $user->role_id) checked @endif>
            </label>
        </div>

        @endforeach
    <button type="submit">确认分配</button>
</form>
</body>
</html>