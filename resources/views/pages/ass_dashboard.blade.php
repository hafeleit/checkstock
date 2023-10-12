@extends('layouts.appguest', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<style media="screen">
@import url(https://fonts.googleapis.com/css?family=Open+Sans:400,600);

*, *:before, *:after {
margin: 0;
padding: 0;
box-sizing: border-box;
}

body {
background: #105469;
font-family: 'Open Sans', sans-serif;
}
table {
background: #012B39;
border-radius: 0.25em;
border-collapse: collapse;
margin: 1em;
}
th {
border-bottom: 1px solid #364043;
color: #E2B842;
font-size: 0.85em;
font-weight: 600;
padding: 0.5em 1em;
text-align: left;
}
td {
color: #fff;
font-weight: 400;
padding: 0.65em 1em;
}
.disabled td {
color: #4F5F64;
}
tbody tr {
transition: background 0.25s ease;
}
tbody tr:hover {
background: #014055;
}


</style>
    <div class="">

        <div class="row">
            <div class="col-6">
              <table>
                <thead>
                  <tr>
                    @for($i=0;$i<30;$i++)
                    <th>ID</th>
                    @endfor
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1
                    <td>Malcolm
                    <td>Reynolds
                    <td>Mal, Cap'n
                    <td>M
                    <td>Captain
                    <td>Yes

                </tbody>
              </table>
            </div>
            <div class="col-6">
              <table>
                <thead>
                  <tr>
                    @for($i=0;$i<30;$i++)
                    <th>ID</th>
                    @endfor
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1
                    <td>Malcolm
                    <td>Reynolds
                    <td>Mal, Cap'n
                    <td>M
                    <td>Captain
                    <td>Yes

                </tbody>
              </table>
            </div>
        </div>
    </div>

@endsection
