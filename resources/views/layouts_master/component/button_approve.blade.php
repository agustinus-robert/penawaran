<form action="{{url($approve)}}" method="POST" enctype="multipart/form-data">
@csrf
{{method_field('PUT')}}
<input type="hidden" name="approve" value="1" />
<button type="submit" class="btn text-success border-success"><i class="fa fa-check" aria-hidden="true"></i></button>
</form>