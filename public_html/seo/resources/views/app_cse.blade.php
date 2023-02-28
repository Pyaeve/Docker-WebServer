@extends('layouts.bs3.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Analisis de SEO</div>

                <div class="card-body">
                    
                
        <div class="row">

             {!! BootForm::open()->get()->inline()!!}
                 @if(isset($_GET['q']))
                     {!! BootForm::text('termino de busqueda','q')->value($_GET['q']) !!}
                 @else
                      {!! BootForm::text('termino de busqueda','q') !!}
                  @endif
                  @if(isset($_GET['o']))
                     {!! BootForm::select('Opciones', 'o')->options(['' => 'Ninguna', 'intext:' => 'que Contenga algun Texto','allintext:'=>
                              'Todo lo que contenga '])->select($_GET['o']) !!}
                  @else
                    {!! BootForm::select('Opciones', 'o')->options(['' => 'Ninguna', 'intext:' => 'que Contenga algun Texto','allintext:'=>
                              'Todo lo que contenga '])->select('Ninguna') !!}
                  @endif
                  {!! BootForm::select('Pais', 'c')->options(['ar'=>'Argentina', 'py'=>
                              'Paraguay'])->select('py') !!}
                   {!! BootForm::submit('Consultar')->addClass('btn btn-success') !!}
                   {!! BootForm::close() !!}
        </div>
        <div class="flex-center position-ref full-height">
            <?php $i=1; ?>
              @foreach($results as $res)
             <!--RESULT # -->
    <div class="result">
      <!--RESULT TITLE -->
      <h3 class="result-title">
        <a href="{!! $res->link !!}">{!! $res->title !!}</a>
      </h3>
      <!-- RESULT WEB ADDRESS (META) -->
      <div> 
        <cite class="meta-web-address">{!! $res->displayLink !!}</cite>
        <div class="action-menu-web-address">
          <a href="{!! $res->link !!}">
            <i class="fa fa-caret-down" aria-hidden="true"></i>
          </a>
        </div>
      </div>
      <!-- META DATE + DESCRIPTION -->
      <div class="meta-description">x
        <span class="date-result">{!! date('d D \de M Y`x') !!}</span>
        {!! $res->htmlSnippet !!}
      </div>
    </div>
    <!---->
    <?php $i++; ?>
    @endforeach
        </div>
    </div>
</div>
</div>
</div>
</div>
@endsection
@section('scripts')
alert('hola');
@endsection
 
