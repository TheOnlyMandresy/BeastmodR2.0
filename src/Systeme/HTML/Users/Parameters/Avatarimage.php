<div class="avatarimage" id="avatarimage_content">
	<nav class="sections content_choix">
	    <ul class="categories first_child">
	        <li class="choice-1 background-image mainNav selected" nav-point="hd" onclick="openNav('hd');setSet('hd')"></li>
	        <li class="choice-2 background-image mainNav" nav-point="hr" onclick="openNav('hr'); setSet('hr');"></li>
	        <li class="choice-3 background-image mainNav" nav-point="ch"onclick="openNav('ch');setSet('ch');"></li>
	        <li class="choice-4 background-image mainNav" nav-point="lg"  onclick="openNav('lg');setSet('lg');"></li>
	    </ul>

	    <ul class="sub" subnav="hr">
	        <li class="nav selected" subnav-point='hair' onclick="setSet('hr');activateSub('hair')">Cheveux</li>
	        <li class="nav" subnav-point='hats' onclick="setSet('ha');activateSub('hats')">Chapeaux</li>
	        <li class="nav" subnav-point='he' onclick="setSet('he');activateSub('he')">Acc. tête</li>
	        <li class="nav" subnav-point='ea' onclick="setSet('ea');activateSub('ea')">Lunettes</li>
	        <li class="nav" subnav-point='fa' onclick="setSet('fa');activateSub('fa')">Acc. visage</li>
	    </ul>
	    
	    <ul class="sub" subnav="ch">
	        <li class="nav selected" subnav-point='ch' onclick="setSet('ch');activateSub('ch')">Hauts</li>
	        <li class="nav" subnav-point='cp' onclick="setSet('cp');activateSub('cp')">Autocollants</li>
	        <li class="nav" subnav-point='cc' onclick="setSet('cc');activateSub('cc')">Vestes</li>
	        <li class="nav" subnav-point='ca' onclick="setSet('ca');activateSub('ca')">Bijoux</li>
	    </ul>
	    
	    <ul class="sub" subnav="lg">
	        <li class="nav selected" subnav-point='lg' onclick="setSet('lg');activateSub('lg')">Pantalons</li>
	        <li class="nav" subnav-point='sh' onclick="setSet('sh');activateSub('sh')">Chaussures</li>
	        <li class="nav" subnav-point='wa' onclick="setSet('wa');activateSub('wa')">Ceintures</li>
	    </ul>
	</nav>

	<div class="editor">
		<div id="option" class="left">
			<div id="clothes"></div>
			<div id="palette"></div>
		</div>
		<div class="right">
			<div id="avatar"></div>
			<div class="divided-2-forced">
				<div class="hover rotate left" onclick="rotateAvatar('left')"></div>
				<div class="hover rotate right" onclick="rotateAvatar('right')"></div>
			</div>
		</div>
	</div>

	<form method="POST">
		<?= $form->input(['name' => 'look',
			'type' => 'hidden',
			'value' => $myDatas->look
		], false); ?>
		
		<div class="buttons-container">
			<?= $form->button(['name' => 'param-look',
				'btn' => 'success', 
				'text' => 'Sauvegarder'
			]); ?>
		</div>
	</form>
	
	<script src="/js/avatar/avatar.js"></script>
	<script> var Avatargenerator = new Avatargenerator(); </script>
    <script src="/js/avatar/avatarimage.js"></script>
</div>