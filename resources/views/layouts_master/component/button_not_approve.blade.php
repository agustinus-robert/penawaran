<form action="{{url($approve)}}" method="POST" enctype="multipart/form-data">
@csrf
{{method_field('PUT')}}
<input type="hidden" name="approve" value="2" />
<button type="submit" class="btn text-danger border-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
</form>