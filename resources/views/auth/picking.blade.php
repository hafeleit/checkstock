@extends('layouts.app')

@section('content')
<style media="screen">
  .input-sm{
    font-size: 0.75rem;
  }
</style>
    <main class="main-content  mt-0">
        <section>
                <div class="container">
                    <div class="row">
                        <div id="tab-login" class="col-xl-3 col-lg-5 col-md-7 mx-lg-0" style="">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start">
                                    <h5 class="font-weight-bolder">LOGIN</h5>
                                </div>
                                <div class="card-body">
                                  <table>
                                    <tr>
                                      <td class="input-sm" align="right">Username:</td>
                                      <td><input type="text" name="" class="input-sm" size="15"></td>
                                    </tr>
                                    <tr>
                                      <td class="input-sm" align="right">Password:</td>
                                      <td><input type="text" name="" class="input-sm" size="15"></td>
                                    </tr>
                                    <tr>
                                      <td class="input-sm" align="right">WH Code:</td>
                                      <td><input type="text" name="" class="input-sm" size="15"></td>
                                    </tr>
                                    <tr>
                                      <td class="input-sm" align="right">Location:</td>
                                      <td><input type="text" name="" class="input-sm" size="15"></td>
                                    </tr>
                                  </table>

                                  <div class="text-center">
                                      <button id="btn-next" type="button" class="btn btn-sm btn-primary btn-sm w-60 mt-4 mb-0">Next</button>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="tab-picking" class="col-xl-3 col-lg-5 col-md-7 mx-lg-0" style=" display:none">
                            <div class="card card-plain">
				<div class="card-header pb-0 text-start">
                                    <h5 class="font-weight-bolder">PICKING</h5>
                                </div>
                                <div class="card-body">
                                  <table>
                                    <tr>
                                      <td class="input-sm" align="right">Ticket:</td>
                                      <td align="right"><input type="text" name="" class="input-sm" size="15"><i class="ni ni-app"></i></td>
                                    </tr>
                                    <tr>
                                      <td class="input-sm" align="right">Position: </td>
                                      <td><input type="text" name="" class="input-sm" size="15"></td>
                                    </tr>
                                    <tr>
                                      <td class="input-sm" align="right">Item/G1/G2: </td>
                                      <td><input type="text" name="" class="input-sm" size="15"></td>
                                    </tr>
                                    <tr>
                                      <td class="input-sm" align="right">Item Desc: </td>
                                      <td><input type="text" name="" class="input-sm" size="15"></td>
                                    </tr>
                                    <tr>
                                      <td class="input-sm" align="right">Batch/Serial:</td>
                                      <td><input type="text" name="" class="input-sm" size="15"><i class="ni ni-air-baloon"></i></td>
                                    </tr>
                                    <tr>
                                      <td class="input-sm" align="right">Pack Code: </td>
                                      <td><input type="text" name="" class="input-sm" size="15"></td>
                                    </tr>
                                    <tr>
                                      <td class="input-sm" align="right">Pack Qty.: </td>
                                      <td><input type="text" name="" class="input-sm" size="6"><input type="text" name="" class="input-sm" size="6"></td>
                                    </tr>
                                    <tr>
                                      <td class="input-sm" align="right">Base Qty.: </td>
                                      <td><input type="text" name="" class="input-sm" size="15" readonly></td>
                                    </tr>
                                  </table>

                                  <div class="text-center">
                                      <button id="btn-save" type="button" class="btn btn-sm btn-primary btn-sm w-60 mt-4 mb-0">Save</button>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        </section>
    </main>

    <script type="text/javascript">
    $(function(){
      $('#btn-next').on('click', function(){
        $('#tab-login').css('display','none');
        $('#tab-picking').css('display','');
      });

      $('#btn-save').on('click', function(){
        alert(0);
      });
    });
    window.addEventListener('keydown',e => {
      var code = e.keyCode || e.which;
      //alert(code);

    });

    </script>
@endsection
