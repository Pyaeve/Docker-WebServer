@extends('layouts.bs3.app')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
           <div class="col-md-12">
               {!! Breadcrumbs::render('SorteosSortear'); !!}
            </div<!-- /.col -->
        </div><!-- /.row -->
        </div> <!-- /.container-fluid -->
         </div> <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                       
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Sorteo de Rifas Vendidas</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5 align="left" id="fechareal"></h5>
                                        </div>
                                        <div class="col-md-6">
                                            <h5 align="right" id="horareal"></h5>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" align="center">
                                            <img style="width: 120px;margin: 10px" class="img img-responsive" src="{!! asset('images/rifachon.png') !!}" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                              <h3 align="center"><b>Agencia:</b>  {!! $agencia_nombre !!}</h3>
                                              <h3 align="center"><b>Jugada Fecha:</b>  {!! $jugada_fecha !!}</h3>
                                              <h3 align="center"><b>Jugada Nro:</b> {!! $jugada_id !!}</h3>
                                             
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                     <!-- Slot machine example -->
<div id="casino" style="padding:0px; margin: 10px;">
    <div class="content">
        
        <div>
            <div id="casino1" class="slotMachine" style="margin-left: 0px;">
             <!--  <div class="slot slot0"></div> -->
                <div class="slot slot1"></div>
                <div class="slot slot2"></div>
                <div class="slot slot3"></div>
                <div class="slot slot4"></div>
                <div class="slot slot5"></div>
                <div class="slot slot6"></div>
                <div class="slot slot7"></div>
                <div class="slot slot8"></div>
                <div class="slot slot9"></div>
            </div>

            <div id="casino2" class="slotMachine">
                <div class="slot slot0"></div>
                <div class="slot slot1"></div>
                <div class="slot slot2"></div>
                <div class="slot slot3"></div>
                <div class="slot slot4"></div>
                <div class="slot slot5"></div>
                <div class="slot slot6"></div>
                <div class="slot slot7"></div>
                <div class="slot slot8"></div>
                <div class="slot slot9"></div>
            </div>
            <div id="casino3" class="slotMachine">
                <div class="slot slot0"></div>
                <div class="slot slot1"></div>
                <div class="slot slot2"></div>
                <div class="slot slot3"></div>
                <div class="slot slot4"></div>
                <div class="slot slot5"></div>
                <div class="slot slot6"></div>
                <div class="slot slot7"></div>
                <div class="slot slot8"></div>
                <div class="slot slot9"></div>
            </div>
            <div id="casino4" class="slotMachine">
                <div class="slot slot0"></div>
                <div class="slot slot1"></div>
                <div class="slot slot2"></div>
                <div class="slot slot3"></div>
                <div class="slot slot4"></div>
                <div class="slot slot5"></div>
                <div class="slot slot6"></div>
                <div class="slot slot7"></div>
                <div class="slot slot8"></div>
                <div class="slot slot9"></div>
            </div>

            <div class="btn-group btn-group-justified" role="group">
                <button id="casinoShuffle" type="button" class="btn btn-primary btn-lg">Sortear!</button>
                <button id="casinoStop" type="button" class="btn btn-primary btn-lg">Parar!</button>
                <button id="casinoReset" type="button" class="btn btn-primary btn-lg">Reiniciar!</button>
            </div>
        </div>
    </div>
    
</div>
<!-- /SlotMachibe -->

   
    
                                        </div>
                                    </div>
                            </div>     
                        </div>
                    </div>
                </div>
            </div>
        </section>
<!-- /.Main content -->
@endsection
@section('scripts')
let count = 0;
var r = "";
const btnShuffle = document.querySelector('#casinoShuffle');
const btnStop = document.querySelector('#casinoStop');
const btnReset = document.querySelector('#casinoReset');
const casino1 = document.querySelector('#casino1');
const casino2 = document.querySelector('#casino2');
const casino3 = document.querySelector('#casino3');
const casino4 = document.querySelector('#casino4');
const mCasino1 = new SlotMachine(casino1, {
  active: 0,
  delay: 500,
  direction: 'up',
  onComplete: function(res){
   var _res = res+1;
   r=_res.toString();
}

});
const mCasino2 = new SlotMachine(casino2, {
  active: 0,
  delay: 500,
  direction: 'up',
   onComplete: function(res){
   r=r+res.toString();
}
});
const mCasino3 = new SlotMachine(casino3, {
  active: 0,
  delay: 500,
  direction: 'up',
   onComplete: function(res){
   r=r+res.toString();
}
});
const mCasino4 = new SlotMachine(casino4, {
  active: 0,
  delay: 500,
  direction: 'up',
   onComplete: function(res){
   r=r+res.toString();
   alert("Vino la Rifa Nro: "+r);
    //meter el sorteo
      
        var url1='{!! env('APP_URL') !!}/api/sorteos/registrar/{!! $agencia_id !!}/{!! $jugada_id !!}/'+r;
        $.ajax({
            url: url1,
           
            beforeSend: function(){
              
              $('#LoaderCircularBlack').show();
          
            }, 
            complete: function(){
                $('#LoaderCircularBlack').hide();
            },
            success: function(res) {
                  r='';
                 },
            error: function() {
                alert("No se ha podido obtener la información");
            }
        });
}

});

   
btnShuffle.addEventListener('click', () => {
  count = 4;
  mCasino1.shuffle(9999);
  mCasino2.shuffle(9999);
  mCasino3.shuffle(9999);
  mCasino4.shuffle(9999);
});

btnStop.addEventListener('click', () => {
  
     setTimeout(function(){
      mCasino1.stop();
     }, 2500);
     setTimeout(function(){
      mCasino2.stop();
     }, 3500);
     setTimeout(function(){
      mCasino3.stop();
     }, 4500);
     setTimeout(function(){
      mCasino4.stop();
     }, 5500);
   
});

btnReset.addEventListener('click',()=>{

      mCasino1._resetPosition();
   
      mCasino2._resetPosition();
     
      mCasino3._resetPosition();
   
      mCasino4._resetPosition();
     
});
//fecha real
function showTime(){
myDate = new Date();
weekday=new Array(7);
weekday[0]="Domingo";
weekday[1]="Lunes";
weekday[2]="Martes";
weekday[3]="Miercoles";
weekday[4]="Jueves";
weekday[5]="Viernes";
weekday[6]="sabado";
monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
  "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Deciembre"
];

 month = myDate.getMonth();
day = myDate.getDate();
n = weekday[myDate.getDay()];
hours = myDate.getHours();
year = myDate.getFullYear();
minutes = myDate.getMinutes();
seconds = myDate.getSeconds();
if (hours < 10) hours = 0 + hours;
if (minutes < 10) minutes = '0' + minutes;
if (seconds < 10) seconds = '0' + seconds;
$('#fechareal').html('<b>Fecha:</b> ' +n +' ' +day+ ' de '+monthNames[month]+' del '+year);
$('#horareal').html('<b>Hora:</b> ' + hours+ ':' +minutes+ ':' +seconds);


}
setInterval(showTime, 500);


@endsection