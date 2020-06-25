@component('mail::message')
# Introduction

Number of Rejected Rows : {{$result["fail"]}}
<br>
Number of Accepted Rows : {{$result["success"]}}


Thanks,<br>
{{ config('app.name') }}
@endcomponent
