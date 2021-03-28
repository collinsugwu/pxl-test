<div style="width: 50%; margin: 0 auto; font-size: 14px; margin-top: 10rem; justify-content: center;">
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <p style="font-size: 16px;">Upload Json file</p>
  <form enctype="multipart/form-data" method="post" post="{{route('create_upload')}}">
    @csrf
    <input style="font-size: 16px;" type="file" name="file">
    <button>Submit</button>
  </form>
</div>
