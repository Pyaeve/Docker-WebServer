<html>
	<head>
		<title>
			Matrix
		</title>
		<style type="text/css">
			body {
  margin: 0;
  padding: 0;
  height: 99%;
  width: 99%;
}
		</style>
	</head>
	<body>
		<canvas id="lienzo"

		></canvas>
	</body>
	<script type="text/javascript">
		const canvas = document.getElementById('lienzo');
const ctx = canvas.getContext('2d');

const w = canvas.width = document.body.offsetWidth;
const h = canvas.height = document.body.offsetHeight;
const cols = Math.floor(w / 20) + 1;
const ypos = Array(cols).fill(0);

ctx.fillStyle = '#000';
ctx.fillRect(0, 0, w, h);

function matrix () {
  ctx.fillStyle = '#0001';
  ctx.fillRect(0, 0, w, h);
  
  ctx.fillStyle = '#15eb16';
  ctx.font = '12px arial';
  
  ypos.forEach((y, ind) => {
    const text = genRandonString(); //String.fromCharCode(Math.random() * 128);
    const x = ind * 20;
    ctx.fillText(text, x, y);
    if (y > 100 + Math.random() * 10000) ypos[ind] = 0;
    else ypos[ind] = y + 20;
  });
}

function genRandonString() {
   var chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789#!*%$]\\_@[] ';
   var charLength = chars.length;
   var result = 	'';
   for ( var i = 0; i < 1; i++ ) {
      result += chars.charAt(Math.floor(Math.random() * charLength));
   }
   return result;
}
setInterval(matrix, 100);
	</script>
</html>