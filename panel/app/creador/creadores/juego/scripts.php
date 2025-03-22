<?php $lista_categorias = [
    "Acción",
    "Aventura",
    "Plataformas",
    "Lucha",
    "Beat 'em up",
    "Shooter",
    "Shooter en primera persona (FPS)",
    "Shooter en tercera persona (TPS)",
    "Battle Royale",
    "Rol (RPG)",
    "Rol de acción",
    "MMORPG",
    "Roguelike",
    "Roguelite",
    "Estrategia",
    "Estrategia en tiempo real (RTS)",
    "Estrategia por turnos",
    "Tower Defense",
    "Simulación",
    "Simulación de vida",
    "Simulación de construcción",
    "Simulación deportiva",
    "Deportes",
    "Carreras",
    "Puzzle",
    "Party Games",
    "Sandbox",
    "Mundo abierto",
    "Horror de supervivencia",
    "Terror psicológico",
    "Novela visual",
    "Juegos narrativos",
    "Metroidvania",
    "Soulslike",
    "Ritmo (Music/Rhythm)",
    "Bullet Hell",
    "MOBA",
    "Cartas",
    "Juegos de mesa",
    "Tycoon",
    "Idle Games",
    "Text Adventures",
    "Clicker",
    "Educación",
    "JRPG",
    "ARPG",
    "Hack and Slash",
    "Shooter cooperativo",
    "Shooter táctico",
    "Gestión de recursos",
    "Exploración espacial",
    "Survival",
    "Realidad virtual (VR)",
    "Realidad aumentada (AR)",
    "Juegos experimentales",
    "Juegos indie",
    "Simulación militar",
    "Dungeon Crawler",
    "Juegos de supervivencia en grupo",
    "Juegos de exploración",
    "Juegos episódicos",
    "Juegos de sigilo",
    "Juegos de detectives",
    "Juegos de cocina",
    "Juegos de granja",
    "Juegos de pesca",
    "Juegos de baile",
    "Juegos de trivia",
    "Juegos de pinball",
    "Juegos de arcade",
    "Juegos de gestión de tiempo",
    "Juegos de economía",
    "Juegos históricos",
    "Juegos educativos para niños",
    "Juegos de rol táctico",
    "Juegos de realidad mixta",
    "Juegos de simulación médica",
    "Juegos de construcción de ciudades",
    "Juegos de supervivencia postapocalípticos",
    "Juegos narrativos interactivos",
    "Juegos basados en física",
    "Juegos artísticos/poéticos",
    "Juegos de combate naval",
    "Juegos de comercio y economía espacial",
    "Juegos de caza",
    "Juegos de mafia",
    "Juegos de guerra estratégica",
    "Juegos de cartas coleccionables",
    "Juegos tipo escape room",
    "Juegos de trivia musical",
]; ?>

<?php $formatos_y_motores = [
    "Ren'Py", // Motor enfocado en novelas visuales y juegos narrativos
    "HTML", // Usado para juegos basados en navegador
    "WebGL", // Tecnología para gráficos 3D en navegadores
    "Unity", // Usado en Hollow Knight, Cuphead y Among Us
    "Godot", // Usado en juegos indie como The Red Strings Club
    "Unreal Engine", // Usado en Fortnite, Gears of War y Borderlands
    "Construct", // Ideal para crear juegos 2D con facilidad
    "CryEngine", // Usado en Crysis y Ryse: Son of Rome
    "PICO-8", // Consola virtual para juegos pixelados
    "Twine", // Herramienta para juegos narrativos y aventuras interactivas
    "Phaser", // Framework para desarrollo de juegos HTML5
    "Cocos2d", // Framework popular para juegos móviles
    "MonoGame", // Usado para juegos multiplataforma
    "Defold", // Motor ligero para juegos 2D y 3D
    "Love2D", // Framework para juegos en 2D basado en Lua
    "Scratch", // Plataforma educativa para crear juegos básicos
    "Stencyl", // Herramienta para crear juegos 2D sin programación
    "LibGDX", // Framework para desarrollo de juegos Java
    "CopperCube", // Motor 3D multiplataforma
    "GDevelop", // Herramienta para crear juegos sin necesidad de código
    "RenderWare", // Usado en GTA III, GTA: Vice City y GTA: San Andreas
    "RAGE", // (Rockstar Advanced Game Engine) Usado en GTA IV, GTA V y Red Dead Redemption 2
    "id Tech", // Usado en DOOM, Quake y Wolfenstein
    "Frostbite", // Usado en Battlefield y Dragon Age: Inquisition
    "Anvil Engine", // Usado en Assassin's Creed y Watch Dogs
    "Creation Engine", // Usado en Skyrim y Fallout 4
    "GameMaker", // Usado en Undertale y Hyper Light Drifter
    "RPG Maker", // Usado en To The Moon y Lisa: The Painful
    "Infinity Engine", // Usado en Baldur's Gate y Planescape: Torment
    "Fox Engine", // Usado en Metal Gear Solid V: The Phantom Pain
    "LithTech", // Usado en F.E.A.R. y Condemned: Criminal Origins
    "GoldSrc", // Usado en Half-Life
    "Source Engine", // Usado en Half-Life 2, Portal y Team Fortress 2
    "Red Engine", // Usado en The Witcher 2 y The Witcher 3
    "Decima Engine" // Usado en Horizon Zero Dawn y Death Stranding
]; ?>

<?php $lista_categorias = array_merge($lista_categorias, $formatos_y_motores); ?>

<?php
$lista_os_requisitos = ["Android", "iOS", "Linux", "Mac OS", "Windows"]; // Sistemas operativos principales para requisitos
$lista_os = array_merge($lista_os_requisitos, [
    // Consolas de Sony
    "PlayStation 1",
    "PlayStation 2",
    "PlayStation 3",
    "PlayStation 4",
    "PlayStation 5",

    // Consolas de Microsoft
    "Xbox", 
    "Xbox 360", 
    "Xbox One", 
    "Xbox Series X", 
    "Xbox Series S",

    // Consolas de Nintendo
    "Nintendo Entertainment System (NES)", 
    "Super Nintendo Entertainment System (SNES)", 
    "Nintendo 64", 
    "GameCube", 
    "Wii", 
    "Wii U", 
    "Nintendo Switch",

    // Portátiles de Nintendo
    "Game Boy", 
    "Game Boy Color", 
    "Game Boy Advance", 
    "Nintendo DS", 
    "Nintendo 3DS",

    // Consolas de Sega
    "Sega Genesis", 
    "Sega Saturn", 
    "Dreamcast",

    // Portátiles de Sony
    "PlayStation Portable (PSP)", 
    "PlayStation Vita",

    // Otras consolas
    "Atari 2600", 
    "Atari Jaguar", 
    "ColecoVision", 
    "Neo Geo", 
    "Commodore 64", 
    "Amiga", 
    "Intellivision", 
    "TurboGrafx-16",

    // Plataformas para VR
    "Oculus Quest", 
    "Oculus Rift", 
    "HTC Vive", 
    "Valve Index", 
    "PlayStation VR", 
    "Meta Quest",

    // Web y streaming
    "Google Stadia", // Plataforma de streaming de juegos
    "Amazon Luna",  // Plataforma de streaming de juegos
    "GeForce Now",  // Plataforma de streaming de Nvidia

    // Otros sistemas
    "Arcade",       // Máquinas recreativas clásicas
    "Steam Deck",   // Consola portátil de Valve
    "Tesla Arcade"  // Juegos integrados en vehículos Tesla
]);
?>


<?php $lista_servidor_descargas = ['MEGA','MediaFire','FireLoad','Gofile', 'OneDrive', 'Drive', 'Utorrent']; ?>