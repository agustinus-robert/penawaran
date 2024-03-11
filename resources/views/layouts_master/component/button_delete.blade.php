<form action="{{url($delete)}}" method="POST" enctype="multipart/form-data">
@csrf
{{method_field('DELETE')}}
<button type="submit" class="btn text-danger border-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
</form>