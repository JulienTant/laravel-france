@if (Session::has('sweet_alert.alert'))
<alert config="{{ Session::get('sweet_alert.alert') }}"></alert>
@endif