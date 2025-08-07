<style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap");
    .container{
        height:12vh;
    }
    .progresses{
        display: flex;
        align-items: center;
    }

    .line{
        width: 120px;
        height: 6px;
        background: #6c757d;
    }
   .steps{
        display: inline-grid;
        background-color: #6c757d;
        color: #fff;
        font-size: 14px;
        width: 40px;
        height: 40px;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        text-align: center;
    }
   .progresses .steps strong{
        width: min-content;
        text-align: center;
        color: #6c757d;
    }
   .active-step{
        color: #63d19e;;
    }
</style>
<div class="container justify-content-center align-items-center "style="width: fit-content;">
    <div class="progresses">
        @foreach($data as $key =>$row)
            <div class="steps {{ $step == $row->id ? 'bg-primary' : ($step > $row->id ? 'bg-success' : '') }}">
                <span class="mt-2"><i class="fa fa-check"></i>{{ $row->step_order }}</span><br>
                <strong class="text-wrap {{ $step == $row->id ? 'text-primary' : '' }}">{{ $row->event_step }}</strong>
            </div>
            @if($key != count($data)-1)
                <span class="line {{ $step == $row->id ? 'bg-primary' : ($step > $row->id ? 'bg-success' : '') }}"></span>
            @endif
        @endforeach    
    </div>    
</div>