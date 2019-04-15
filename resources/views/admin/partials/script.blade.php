<script data-exec-on-popstate>

    $(function () {
        @foreach($script as $s)
            {!! $s !!}
        @endforeach

        $('.menu li').click(function(){
        	$(this).addClass('on')
        	$(this).siblings('li').removeClass('on')
        })
    });
</script>
