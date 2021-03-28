<div>
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <form enctype="multipart/form-data" method="post" post="{{route('create_upload')}}">
    @csrf
    <input type="file" name="file">
    <button>Submit</button>
  </form>
</div>
