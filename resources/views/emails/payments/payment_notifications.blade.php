<x-mail::message>
# Introduction

Client: {{$client}} </br>
Status: {{$status}} </br>
Date: {{$date}}


<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
