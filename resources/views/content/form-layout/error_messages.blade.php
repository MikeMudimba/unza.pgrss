@if(session()->has('error'))
    <!--<div class="alert bg-danger alert-styled-left">-->
    <div class="alert alert-danger alert-styled-left">
        <span class="text-semibold">Error! </span> {{session()->get('error')}}
    </div>
@endif

@if(session()->has('warning'))
    <div class="alert bg-warning alert-styled-left">
        <span class="text-semibold">Warning!</span> {{session()->get('warning')}}
    </div>
@endif

@if(session()->has('success'))
    <!--<div class="alert bg-success alert-styled-left">-->
    <div class="alert alert-success alert-styled-left">
        <span class="text-semibold">Success!</span> {{session()->get('success')}}
    </div>
@endif

@if(session()->has('info'))
    <div class="alert bg-info alert-styled-left">
        <span class="text-semibold">Info!</span> {{session()->get('info')}}
    </div>
@endif