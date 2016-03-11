@if(isset($project))
<ol class="breadcrumb visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block">
  <li><a href="/project/{{ $project->project->id }}">{{ $project->project->name }}</a></li>
  <li class="active">{{ $project->type }}</li>
</ol>
@endif
