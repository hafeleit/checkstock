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
                        <div id="tab-login" class="col-xl-5 col-lg-5 col-md-7 mx-lg-0" style="">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start">
                                    <h5 class="font-weight-bolder">LOGIN</h5>
                                </div>
                                <div class="card-body">
                                  <table>
                                    <tr>
                                      <td class="input-sm" align="right">Username:</td>
                                      <td><input type="text" name="username" id="username" class="input-sm" size="15"></td>
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
                                      <button id="btn-next" type="button" class="btn btn-sm btn-primary btn-sm w-50 mt-4 mb-0">Next</button>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="tab-picking" class="row" style="display: none;">

                      <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                          <div class="nav-wrapper position-relative end-0">
                              <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                  <li class="nav-item">
                                      <a class="nav-link mb-0 px-0 py-1 active d-flex align-items-center justify-content-center "
                                          data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="true">
                                          <span class="ms-2">PICKING</span>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center "
                                          data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                                          <span class="ms-2">PRODUCT</span>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center "
                                          data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                                          <span class="ms-2">Settings</span>
                                      </a>
                                  </li>
                              </ul>
                          </div>
                      </div>

                        <div class="col-xl-4 col-lg-5 col-md-7 mx-lg-0">
                          <div class="card card-plain">
                              <div class="card-body">
                                <table>
                                  <tr>
                                    <td class="input-sm" align="right">Ticket:</td>
                                    <td align="right"><input type="text" name="ticket" id="ticket" class="input-sm" size="15"><i class="ni ni-app"></i></td>
                                  </tr>
                                  <tr>
                                    <td class="input-sm" align="right">Position: </td>
                                    <td><input type="text" name="position" id="position" class="input-sm" size="15"></td>
                                  </tr>
                                  <tr>
                                    <td class="input-sm" align="right">Item/G1/G2: </td>
                                    <td><input type="text" name="itemg1g2" id="itemg1g2" class="input-sm" size="15"></td>
                                  </tr>
                                  <tr>
                                    <td class="input-sm" align="right">Item Desc: </td>
                                    <td><input type="text" name="item_desc" id="item_desc" class="input-sm" size="15"></td>
                                  </tr>
                                  <tr>
                                    <td class="input-sm" align="right">Batch/Serial:</td>
                                    <td><input type="text" name="serial" id="serial" class="input-sm" size="15"><i class="ni ni-air-baloon"></i></td>
                                  </tr>
                                  <tr>
                                    <td class="input-sm" align="right">Pack Code: </td>
                                    <td><input type="text" name="pack_code" id="pack_code" class="input-sm" size="15"></td>
                                  </tr>
                                  <tr>
                                    <td class="input-sm" align="right">Pack Qty.: </td>
                                    <td><input type="text" name="pack_qty" id="pack_qty1" class="input-sm" size="6"><input type="text" name="" id="pack_qty2" class="input-sm" size="6"></td>
                                  </tr>
                                  <tr>
                                    <td class="input-sm" align="right">Base Qty.: </td>
                                    <td><input type="text" name="base_qty" id="base_qty" class="input-sm" size="15" readonly></td>
                                  </tr>
                                </table>

                                <div class="text-center">
                                    <button id="btn-save" type="button" class="btn btn-sm btn-primary btn-sm w-50 mt-4 mb-0">Save</button>
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
      $('#username').focus();
      //click next button
      $('#btn-next').on('click', function(){
        $('#tab-login').css('display','none');
        $('#tab-picking').css('display','');
        $('.moving-tab').css('width','35%');
        //$('#ticket').focus();
      });

      $('#btn-save').on('click', function(){
        alert('Successfuly');
      });

      $('#ticket').on('keyup', function(){
        let ticket = $(this).val();
        $.ajax({
          method: "GET",
          url: "https://app.hafele.co.th/products",
          data: {
            ticket: ticket,
          }
        }).done(function( msg ) {
          $('#itemg1g2').val('G8854851');
          $('#item_desc').val('DESC885123');
          $('#pack_code').val('PC985444');
          $('#pack_qty1').val('5');
          $('#pack_qty2').val('9');
          $('#base_qty').val('98');

          $('#position').focus();
        });

      });

    });

    window.addEventListener('keydown',e => {
      var code = e.keyCode || e.which;
      //alert(code);

    });

    </script>
@endsection
