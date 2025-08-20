<!DOCTYPE HTML>
<html>
	<head>
		<title>Mi Web - <?= NOMBRE_EMPRESA; ?></title>
		<link rel="icon" href="<?= site_url(); ?>favicon.ico">
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="<?= site_url(); ?>public/mi-web/assets/css/main.css" />
		<link rel="stylesheet" href="<?= site_url(); ?>public/css/link-miweb.css" />
	</head>
	<body class="homepage is-preload">
		<div id="page-wrapper">

			<!-- Header -->
				<div id="header-wrapper">
					<!-- Hero -->
					<section id="hero" class="container">
						<header>
							<div class="row align-items-center">
								<div class="col-auto">
									<img src="<?= base_url(); ?>public/images/logo-gom.png" alt="logo" class="img-size-100 mr-3 img-circle" id="logo-gom">
								</div>
								<div class="col">
									<h2 id="h2-text-left" class="mb-0">¡Oportunidad Única en Network Marketing! con Trading Automático</h2>
								</div>
							</div>
						</header>
					</section>

				</div>

			<!-- Features 1 -->
				<div class="wrapper">
					<div class="container">
						<div class="row">
							<div class="col-md-12" id="video-plan">
								<iframe width="560" height="315" src="https://www.youtube.com/embed/VKc2JjcR73w?si=mTxgcci-oqgfgyyB" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
							</div>
						</div>
						<div class="row">
							<section class="col-6 col-12-narrower feature">
								<div class="image-wrapper first">
									<a href="#" class="image featured first"><img src="images/pic01.jpg" alt="" /></a>
								</div>
								<header>
									<img src="<?= base_url(); ?>public/images/logo-gom.png" alt="logo" class="img-size-50 mr-3 img-circle" id="logo-gom">
								</header>
								<p>"Nuestra visión es ser una comunidad global de personas que viven con propósito y pasión, libres de las limitaciones financieras y temporales que impiden alcanzar sus sueños. Queremos ser un faro de esperanza y oportunidad para aquellos que buscan mejorar su situación financiera y disfrutar de una vida más equilibrada y plena. En Gigantesonemillon, creemos que todos merecen vivir una vida de libertad y propósito, y nos comprometemos a hacer realidad esta visión para nosotros y para los demás."</p>
								<h3>Nuestros valores</h3><p>Unidad: Creemos en la importancia de la unidad y la colaboración para alcanzar nuestros objetivos y hacer un impacto positivo en la vida de las personas.
Servicio: Nos comprometemos a servir a nuestros miembros y a la comunidad con integridad y dedicación, buscando siempre agregar valor y hacer una diferencia positiva.
Integridad: Valoramos la honestidad, la transparencia y la ética en todas nuestras acciones y decisiones, y nos esforzamos por mantener la confianza y el respeto de nuestros miembros y de la comunidad.</p>
							</section>
							<section class="col-6 col-12-narrower feature">
								<div class="image-wrapper">
									<a href="#" class="image featured"><img src="images/pic02.jpg" alt="" /></a>
								</div>
								<header>
									<h2>Ventajas de las Redes de Mercadeo</h2>
								</header>
									<h4 class="mb-2">Las redes de mercadeo con trading automático pueden ser atractivas por varias razones:</h4>
									<p><h3>Potencial de ingresos pasivos</h3> El trading automático puede generar ingresos sin requerir intervención manual constante.</p>
									<p><h3>Escalabilidad</h3> Las redes de mercadeo permiten expandir la base de clientes y reclutadores, aumentando el potencial de ganancias.</p>
									<p><h3>Diversificación de ingresos</h3> Combinar trading con redes de mercadeo puede diversificar las fuentes de ingresos.</p>
									<p><h3>Automatización</h3> El trading automático reduce el tiempo y esfuerzo necesarios para tomar decisiones de inversión.</p>
								</p>
								<ul class="actions">
									<li><a href="https://youtu.be/jL3-yV2LXvw?si=HgPeriDA0XKGMHnS" class="button" target="_blank">Aprende a invertir y ganar</a></li>
								</ul>
							</section>
						</div>
					</div>
				</div>

			<!-- Promo -->
				<div id="promo-wrapper">
					<section id="promo">
						<h2>Ingrese a formar parte de la mejor red de negocio <?= NOMBRE_EMPRESA; ?></h2>
						<a href="#" class="button">Conozca sus beneficios</a>
					</section>
				</div>

			<!-- Features 2 -->
				<div class="wrapper">
					<section class="container">
						<header class="major">
							<h2>Ventajas del Trading</h2>
						</header>
						<div class="row features">
							<section class="col-4 col-12-narrower feature">
								<iframe width="560" height="315" src="https://www.youtube.com/embed/qhMZU1OeZIk?si=slpI2YTK1b8v3T-w" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
							</section>
							<section class="col-2 col-12-narrower feature"></section>
							<section class="col-4 col-12-narrower feature">
								<iframe width="560" height="315" src="https://www.youtube.com/embed/S8vjehL1usI?si=rtip6lwYtcqqbkKk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
							</section>
						</div>
					</section>
				</div>

			<!-- Footer -->
				<div id="footer-wrapper">
					<div id="footer" class="container">
						<header class="major">
							<h2>Formulario de inscripción</h2>
							<p>Registrate y comienza A GANAR con "Ganadoresonemillion"
						</header>
						<div class="row">
							<section class="col-6 col-12-narrower">
								<form  class="form" method="post" action="<?= site_url(); ?>new-member-insert">
									<div class="row gtr-50">
										<div class="col-6 col-12-mobile">
											<label for="nombre">Nombre</label>
											<input name="nombre" class="form-control" placeholder="Nombre" type="text" id="nombre" required autocomplete="name"/>
											<div class="valid-feedback">Correcto!</div>
                    						<div class="invalid-feedback">Por favor debe registrar su nombre.</div>
										</div>
										<div class="col-6 col-12-mobile">
											<label for="user">Usuario</label>
											<input name="user" class="form-control" placeholder="Usuario" type="text" id="user" required/>
										</div>
										<div class="col-6 col-12-mobile">
											<label for="password">Password</label>
											<input name="password" class="form-control" placeholder="Password" type="password" id="password" required/>
										</div>
										<div class="col-6 col-12-mobile">
											<label for="cedula">DNI o Cédula</label>
											<input name="cedula" class="form-control" placeholder="DNI o Cédula" type="text" id="cedula" required/>
										</div>
										<div class="col-6 col-12-mobile">
											<label for="telefono">Teléfono</label>
											<input name="telefono" class="form-control" placeholder="Teléfono" type="text" id="telefono" required/>
										</div>
										<div class="col-6 col-12-mobile">
											<label for="telefono_2">Whatsapp</label>
											<input name="telefono_2" class="form-control" placeholder="telefono_2" type="text" id="telefono_2"/>
										</div>
										<div class="col-6 col-12-mobile">
											<label for="email">Email de la wallet</label>
											<input name="email" class="form-control" placeholder="Email de la wallet" type="email" id="email" />
										</div>
										<div class="col-6 col-12-mobile">
											<label for="pais">País</label>
											<input name="pais" class="form-control" placeholder="País" type="text" id="pais" value="Ecuador" readonly />
										</div>
										<div class="col-6 col-12-mobile" id="div-provincia-ecuador">
											<label for="idprovincia">Provincia</label>
											<select class="form-select" id="provincias" name="idprovincia" required>
												<option selected disabled value="">--Escoja una provincia--</option>
												<?php
													if ($provincias) {
														foreach ($provincias as $key => $provincia) {
															echo '<option value="'.$provincia->id.'">'.$provincia->provincia.'</option>';
														}
													} else {
														# code...
													}
													
												?>
											</select>
										</div>
										<div class="col-6 col-12-mobile" id="div-provincia-otro-pais">
											<label for="provincia">Provincia/Estado/Distrito </label>
											<input name="provincia" class="form-control" placeholder="Provincia/Estado/Distrito" type="text" id="provincia"/>
										</div>
										<div class="col-6 col-12-mobile" id="div-ciudad-otro-pais">
											<label for="ciudad">Ciudad</label>
											<input name="ciudad" class="form-control" placeholder="ciudad" type="text" id="ciudad"/>
										</div>
										<div class="col-6 col-12-mobile" id="div-ciudad-ecuador">
											<label for="idciudad">Ciudad</label>
											<select 
												class="form-select" 
												id="idciudad" 
												name="idciudad" 
												required 
												disabled>
											</select>
										</div>
										<div class="col-6 col-12-mobile">
											<label for="direccion">Dirección</label>
											<input name="direccion" class="form-control" placeholder="Direccion" type="text" id="direccion"/>
										</div>
										<div class="col-9 col-12-mobile">
											<label for="suscripción" class="form-label">Suscripción:</label>
											<input name="suscripción" class="form-control" placeholder="suscripción" type="text" id="suscripción" value="150.00" readonly/>
										</div>
										<div class="col-12">
											<div class="form-check">
												<input 
													name="chkTerminos" 
													class="form-check-input" 
													type="checkbox" 
													id="invalidCheck" 
													value="1"
												/>
												<label class="form-check-label" for="invalidCheck">Estoy de acuerdo con los téminos y condiciones del sitio</label>
											</div>
										</div>
										<div class="col-12">
											<ul class="actions">
												<?= form_hidden('origen', 'web'); ?> 
												<li><input type="submit" value="Registrar" /></li>
												<li><input type="reset" value="Limpiar formulario" /></li>
												<li><input type="button" value="Llenar" onclick="autollenarFormulario()" hidden/></li>
											</ul>
										</div>
									</div>
								</form>
							</section>
							<section class="col-6 col-12-narrower">
								<div class="row gtr-0">
									<ul class="divided icons col-6 col-12-mobile">
										<li class="icon brands fa-twitter"><a href="#"><span class="extra">twitter</span></a></li>
										<li class="icon brands fa-facebook-f"><a href="#"><span class="extra">facebook</span></a></li>
										<li class="icon brands fa-tiktok"><a href="#"><span class="extra">tiktok</span></a></li>
									</ul>
									<ul class="divided icons col-6 col-12-mobile">
										<li class="icon brands fa-instagram"><a href="#"><span class="extra">instagram</span></a></li>
										<li class="icon brands fa-youtube"><a href="#"><span class="extra">youtube</span></a></li>
										<li class="icon brands fa-pinterest"><a href="#"><span class="extra">pinterest</span></a></li>
									</ul>
								</div>
							</section>
						</div>
					</div>
					<div id="copyright" class="container">
						<ul class="menu">
							<li>&copy; Derechos reservados.</li><li>Diseñado por: <a href="https://www.facebook.com/appdvp/" target="_blank">Appdvp</a></li>
						</ul>
					</div>
				</div>

		</div>

		<!-- Scripts -->
		<script src="<?= site_url(); ?>public/mi-web/assets/js/jquery.min.js"></script>
		
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    	<script src="<?= site_url(); ?>public/js/mi-web-form-new-member.js"></script>
	</body>
</html>