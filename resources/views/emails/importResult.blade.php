@component('mail::message')
# Introduction

Number of Rejected Rows : {{$result["fail"]}}
Number of Accepted Rows : {{$result["success"]}}


Thanks,<br>
{{ config('app.name') }}
@endcomponent
