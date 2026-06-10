<div id="alertt-alert">
	<style>
		#alertt { 
			width: 90%;
			background-color: rgba(255, 255, 255, 0.85);
			max-width: {{ config('alertt.max_width', '500px') }};
			min-width: {{ config('alertt.min_width', '300px') }};
		    border: 0px solid #ccc;
		    border-radius: {{ config('alertt.border_radius', '5px') }};
		    box-shadow: 0px 0px 12px 0px #ccc;
		    font-family: Arial, Helvetica, sans-serif;
		    border-left: 6px solid #333;
		    position: fixed;
		    z-index: {{ config('alertt.z_index', 9999) }};
		    bottom: {{ config('alertt.bottom', '25px') }};
		    right: {{ config('alertt.right', '25px') }};
		    top: {{ config('alertt.top', null) }};
		    left: {{ config('alertt.left', null) }};

		    color: {{ $color }};
		    border-color: {{ $borderColor }};
		}
		#alertt .alertt-header, #alertt .alertt-body, #alertt .alertt-footer{
			padding: 8px 12px;
			border-bottom: 1px solid #efefef;
		}
		#alertt .alertt-header{ 
			padding-top: 0px;
			padding-bottom: 0px;
			padding-right: 0px;
			font-size: {{ config('alertt.header.font_size', '16px') }};
			font-weight: 500;
			display: flex;
			justify-content: space-between;
			background-color: #f1f1f1;
		}
		#alertt .alertt-header .l-title{
			padding-right: 6px;
			margin: auto 0;
		}
		#alertt .alertt-header .l-close{
			cursor: pointer;
			color: red;
			padding: 10px 16px;
			border-left: 1px solid #efefef;
			font-weight: 600;
		}
		#alertt .alertt-header .l-close:hover{
			background: #efefef;
		}
		#alertt .alertt-body{
			font-size: {{ config('alertt.body.font_size') ? config('alertt.body.font_size') : '15px' }};
			line-height: {{ config('alertt.body.line_height') ? config('alertt.body.line_height') : '20px' }};
			color: #333;
			font-weight: 500;
			padding-top: 12px;
			padding-bottom: 12px;
		}
		#alertt .alertt-body ul{
			margin-bottom: 0px;
			padding-left: 1rem;
		}
		#alertt .alertt-footer{
			font-size: {{ config('alertt.footer.font_size', '13px') }};
		}
	</style>

	<div id="alertt" class="l-{{ $type }} {{ config('alertt.class') }}">
		<div class="alertt-header">
			<div class="l-title">{{ $title }}</div>
			<div class="l-close" id="l-close" onclick="alerttClose()">x</div>
		</div>
		<div class="alertt-body">
			{!! $message !!}
		</div>
		
		@if($footer)
			<div class="alertt-footer">
				{{ $footer }}
			</div>
		@endif
		<script>
			setTimeout(alerttClose, {{ $timeout }});
			function alerttClose(){
				document.getElementById('alertt-alert').remove();
			}
		</script>
	</div>
</div>