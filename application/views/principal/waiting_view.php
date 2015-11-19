<div id="canvas"></div>
    <a href="<?php echo base_url(); ?>principal/menu">Saltar</a>
</div>

    <script>
	var camera, scene, renderer;
	var mesh;

	init();
	animate();

	function init() {
            base_url = $('#base_url').val();
            //Render
            renderer = new THREE.WebGLRenderer({ antialias: true });
            renderer.setSize(550, 531);
            renderer.setClearColor(0xffffff, 1);
            document.getElementById("canvas").appendChild(renderer.domElement);

            //Camara
            camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 1, 1000);
            camera.position.y = 0;
            camera.position.z = 200;

            //Escena
            scene = new THREE.Scene();

            var texture = THREE.ImageUtils.loadTexture(base_url + "images/logo.png" );
            var material = new THREE.MeshBasicMaterial( {map: texture} );

            //Plano
            mesh = new THREE.Mesh(new THREE.PlaneGeometry(220,130,0,0), material);
            mesh.material.side = THREE.DoubleSide;
            scene.add(mesh);
	}

	function animate() {
            requestAnimationFrame(animate);
            mesh.rotation.y += 0.02;
            renderer.render( scene, camera );
	}
</script>