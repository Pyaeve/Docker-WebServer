@extends('themes.bs5started.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Analiysis de SEO</div>

                <div class="card-body">\
                    <div class="row">
                        
                    
                        <div class="col-md-12">
                             {!! BootForm::open()->get()->inline()!!}
                 @if(isset($_GET['url']))
                     {!! BootForm::text('URL del Sitio Web','url')->value($_GET['url']) !!}
                 @else
                      {!! BootForm::text('URL del Sitio Web','url') !!}
                  @endif
                
               
                   {!! BootForm::submit('Consultar')->addClass('btn btn-success') !!}
                   {!! BootForm::close() !!}
                        </div>
                    </div>
                    
                     <div class="row">
                        <div class="col-md-12">
                            
                           @foreach($seo_tags as $seo)
                                
                           @endforeach

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @if(isset($serp))
                                <div class="flex-center position-ref full-height">
              @foreach($serp as $res)
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
      <div class="meta-description">
        
        {!! $res->htmlSnippet !!}
      </div>
    </div>
    <!---->
    @endforeach
        </div>
                        </div>
                        @endif
                     </div>

                   		
                   				
                   		
                   		
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
