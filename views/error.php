<html>
    <head>
        <title>No Access</title>
        <style>
            $font: 'Poppins', sans-serif;
            body {
            	width: 100%;
            	height: 100vh;
            	display: flex;
            	align-items: center;
            	justify-content: center;
            	flex-direction: column;
            	family: $font;
            		background-image: linear-gradient(45deg, #f6d200 25%, #181617 25%, #181617 50%, #f6d200 50%, #f6d200 75%, #181617 75%, #181617 100%);
            }
            
            h1 { 
            	text-transform: uppercase;
            	background: repeating-linear-gradient(
              45deg,
              #f6d200 ,
              #f6d200  10px,
              #181617  10px,
              #181617  20px
            );
            	-webkit-background-clip: text;
            	-webkit-text-fill-color: transparent;
            	/*animation: move 5s ease infinite;*/
            	font-size: 384px;
            	margin: 0;
            	line-height: .7;
            	position: relative;
            	&:before,
            	&:after{
            		content: "Caution";
            			background-color: #f6d200;
            			color: #181617;
            			border-radius: 10px;
            			font-size: 35px;
            			position: absolute;
            			padding: 31px;
            			text-transform: uppercase;
            			font-weight: bold;
            			-webkit-text-fill-color: #181617;
            			left: 50%;
            			top: 50%;
            			transform: translate(-50%, -50%) rotate(20deg);
            	}
            	&:before {
            		content: "";
            		padding: 70px 130px;
            		background: repeating-linear-gradient(45deg, #f6d200, #f6d200 10px, #181617 10px, #181617 20px);
            		box-shadow: 0px 0px 10px #181617;
            	}
            	& span:before,
            	& span:after{
            		content: "";
            			width: 8px;
            			height: 8px;
            			background: #757575;
            			color: #757575;
            			border-radius: 50%;
            			position: absolute;
            			bottom: 0;
            			margin: auto;
            			top: 20%;
            			z-index: 3;
            			box-shadow: 0px 60px 0 0px;
            	}
            	span:before {
            		left: 37%;
                transform: rotate(22deg);
                top: -44%;
            	}
            	span:after {
            		right: 34%;
                transform: rotate(22deg);
                top: 3%;
            	}
            }
        </style>
    </head>
    <body>
        <h1 class="text"><span>403</span></h1>
    </body>
</html>