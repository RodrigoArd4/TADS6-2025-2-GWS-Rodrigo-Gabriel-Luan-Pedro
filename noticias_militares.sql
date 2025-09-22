-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 23/09/2025 às 00:08
-- Versão do servidor: 8.0.40
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `noticias_militares`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`) VALUES
(6, 'Aviões', 'avioes'),
(7, 'Tanques', 'tanques'),
(8, 'Navios', 'navios');

-- --------------------------------------------------------

--
-- Estrutura para tabela `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `post_id` int NOT NULL,
  `user_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `approved` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `content` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_id` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `status` enum('draft','published') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `posts`
--

INSERT INTO `posts` (`id`, `title`, `summary`, `content`, `image_path`, `author_id`, `category_id`, `status`, `created_at`, `updated_at`) VALUES
(6, 'Tiger H1', 'O Tiger H1 foi um dos mais icônicos tanques pesados da Segunda Guerra Mundial, desenvolvido pela Alemanha nazista. Reconhecido por sua blindagem espessa e canhão de alto poder, representava a superioridade tecnológica alemã no campo de batalha.', 'O Panzerkampfwagen VI Tiger Ausf. H1, popularmente chamado de Tiger I, entrou em serviço em 1942 e rapidamente se tornou temido pelos Aliados. Projetado pela Henschel, pesava cerca de 57 toneladas e era equipado com o canhão KwK 36 L/56 de 88 mm, derivado das temidas armas antiaéreas Flak. Sua blindagem frontal chegava a 100 mm, tornando-o quase invulnerável aos tanques inimigos de sua época, especialmente nas primeiras campanhas.\r\nO Tiger H1 foi utilizado pela Wehrmacht e Waffen-SS em diversos teatros da guerra, incluindo a Frente Oriental contra o Exército Vermelho e o Norte da África sob o comando de Erwin Rommel. Embora extremamente poderoso, apresentava problemas de mobilidade e confiabilidade mecânica, além de custos de produção elevados e alto consumo de combustível. Apenas cerca de 1.347 unidades foram fabricadas, o que limitou seu impacto estratégico.\r\nAinda assim, sua presença no campo de batalha influenciou o desenvolvimento de veículos aliados, que tiveram de projetar armas e táticas específicas para enfrentá-lo. O Tiger H1 permanece até hoje como símbolo da engenharia militar alemã e da escalada tecnológica dos blindados durante a Segunda Guerra Mundial.', '/uploads/1758564681_37f233fd.jpg', 2, 7, 'published', '2025-09-22 18:11:21', '2025-09-22 18:11:21'),
(7, 'Panther D', 'O Panther D foi a primeira versão de produção do tanque médio alemão Panzer V, desenvolvido durante a Segunda Guerra Mundial. Criado como resposta aos tanques soviéticos T-34, combinava blindagem inclinada, bom poder de fogo e mobilidade, tornando-se um dos blindados mais equilibrados do conflito.', 'O Panzerkampfwagen V Panther Ausf. D entrou em serviço em 1943, sendo projetado pela MAN após a Alemanha enfrentar sérias dificuldades contra os T-34 soviéticos. Pesando cerca de 44,8 toneladas, o Panther D era equipado com o canhão KwK 42 L/70 de 75 mm, capaz de penetrar a blindagem da maioria dos tanques aliados a longas distâncias. Sua blindagem frontal chegava a 80 mm, disposta em ângulos inclinados que aumentavam a eficácia defensiva, inspirados diretamente no design do T-34.\r\nO Panther D estreou em combate durante a Batalha de Kursk, em julho de 1943, mas apresentou diversos problemas mecânicos, como falhas no motor e na transmissão. Apesar disso, quando operacional, mostrou-se extremamente eficaz, combinando poder de fogo superior ao do Panzer IV e velocidade maior que a do Tiger I.\r\nProduzido em aproximadamente 842 unidades, o Panther D serviu como base para versões posteriores mais refinadas, como o Panther A e o Panther G. Embora suas falhas iniciais tenham comprometido seu desempenho em Kursk, o Panther acabou se tornando um dos melhores tanques da guerra, equilibrando potência, blindagem e mobilidade em um projeto que influenciou o design de blindados no pós-guerra.', '/uploads/1758564751_8bcad66a.jpg', 2, 7, 'published', '2025-09-22 18:12:31', '2025-09-22 18:12:31'),
(8, 'Jagdtiger', 'O Jagdtiger foi o mais pesado caça-tanques utilizado na Segunda Guerra Mundial. Desenvolvido pela Alemanha nazista, possuía blindagem impenetrável para a maioria das armas aliadas e carregava um canhão antitanque de altíssimo calibre, tornando-se uma ameaça devastadora em combate defensivo.', 'O Panzerjäger Tiger Ausf. B, conhecido como Jagdtiger, entrou em serviço em 1944 e foi baseado no chassi do Tiger II (Königstiger). Com impressionantes 75 toneladas, era o veículo blindado de combate mais pesado do conflito. Seu armamento principal era o canhão PaK 44 L/55 de 128 mm, capaz de destruir qualquer blindado aliado a distâncias superiores a 3 km. Sua blindagem frontal alcançava 250 mm, tornando-o praticamente invulnerável a ataques frontais.\r\nApesar de sua força formidável, o Jagdtiger apresentava sérios problemas logísticos. O peso excessivo dificultava a mobilidade, exigindo estradas sólidas e pontes reforçadas. Seu consumo de combustível era altíssimo e o motor Maybach HL230, o mesmo utilizado em veículos mais leves, sofria para movimentar a estrutura colossal. Além disso, o número de unidades produzidas foi muito limitado — cerca de 70 a 80 veículos entre 1944 e 1945.\r\nO Jagdtiger foi utilizado principalmente em frentes defensivas, como durante as batalhas no front ocidental, incluindo a ofensiva das Ardenas. No entanto, seu impacto real foi menor do que seu potencial, já que problemas mecânicos, falta de suprimentos e o colapso da Alemanha impediram que fosse empregado em larga escala. Ainda assim, o Jagdtiger se tornou um símbolo da busca alemã por armas “superpesadas” e da filosofia de produzir blindados de supremacia absoluta, mesmo que impraticáveis no campo de batalha.', '/uploads/1758564825_472fcaf7.jpg', 2, 7, 'published', '2025-09-22 18:13:45', '2025-09-22 18:13:45'),
(9, 'Leopard 2A7', 'O Leopard 2A7 é a versão mais moderna do principal carro de combate alemão, projetado para enfrentar ameaças contemporâneas em ambientes urbanos e campos de batalha convencionais. Combinando mobilidade, alta proteção e poder de fogo avançado, é considerado um dos melhores tanques do mundo na atualidade.', 'Desenvolvido pela Krauss-Maffei Wegmann (KMW) e introduzido em 2014, o Leopard 2A7 é uma evolução do Leopard 2, que desde a década de 1970 tem sido a espinha dorsal das forças blindadas alemãs e de diversos países da OTAN. Pesando cerca de 67 toneladas, é equipado com o canhão Rheinmetall L/55 de 120 mm, capaz de disparar munições perfurantes de última geração, incluindo projéteis programáveis que permitem enfrentar infantaria em cobertura ou drones leves.\r\n\r\nSua blindagem modular oferece proteção contra projéteis cinéticos, munições químicas, minas terrestres e IEDs (artefatos explosivos improvisados), além de permitir upgrades futuros. O tanque possui ainda sistemas avançados de controle de tiro, sensores térmicos de última geração, comunicações digitais integradas e climatização reforçada para operações prolongadas.\r\n\r\nO Leopard 2A7 foi pensado tanto para combates de alta intensidade contra blindados inimigos quanto para operações urbanas, onde conta com blindagem adicional lateral e de teto, metralhadoras remotamente controladas e sistemas de proteção ativa. Atualmente, está em serviço principalmente com o Exército Alemão (Bundeswehr), mas também desperta interesse de diversos países aliados.\r\n\r\nGraças ao equilíbrio entre proteção, poder de fogo e eletrônica de ponta, o Leopard 2A7 é frequentemente considerado o tanque mais avançado do mundo em operação, rivalizando diretamente com modelos como o M1A2 Abrams SEP v3 dos EUA, o francês Leclerc XLR e o britânico Challenger 3.', '/uploads/1758564900_4096e4b6.jpg', 2, 7, 'published', '2025-09-22 18:15:00', '2025-09-22 18:15:00'),
(10, 'Spitfire F Mk 24', 'O Spitfire F Mk 24 foi a versão final e mais avançada do lendário caça britânico Spitfire. Desenvolvido no pós-Segunda Guerra Mundial, combinava a icônica manobrabilidade do modelo original com motores mais potentes, armamento moderno e maior velocidade.', 'O Supermarine Spitfire F Mk 24 entrou em serviço em 1946, sendo a última variante operacional do caça que se tornou símbolo da Batalha da Grã-Bretanha. Equipado com o motor Rolls-Royce Griffon 85 de 12 cilindros, com potência superior a 2.000 hp, o Mk 24 podia alcançar velocidades de até 730 km/h, superando amplamente as primeiras versões de guerra.\r\n\r\nEm termos de armamento, trazia quatro canhões Hispano Mk V de 20 mm, muito mais eficazes contra aeronaves inimigas e alvos terrestres. Também era capaz de carregar bombas e foguetes, ampliando sua versatilidade para missões de ataque ao solo. Seu alcance chegava a 760 km, podendo ser estendido com tanques auxiliares.\r\n\r\nApesar de representar o auge do desenvolvimento do Spitfire, o Mk 24 entrou em serviço em uma era dominada pelos jatos a reação, o que rapidamente o tornou obsoleto frente a aeronaves como o Gloster Meteor e o MiG-15. Mesmo assim, foi utilizado pela Royal Air Force até 1952, principalmente em tarefas secundárias e operações em colônias britânicas.\r\n\r\nO Spitfire F Mk 24 encerrou com dignidade a história de um dos caças mais icônicos de todos os tempos, simbolizando a transição entre a era da hélice e a era dos jatos.', '/uploads/1758564950_9e04c159.jpg', 2, 6, 'published', '2025-09-22 18:15:50', '2025-09-22 18:15:50'),
(11, 'MiG-15', 'O MiG-15 foi um dos primeiros caças a jato de sucesso da União Soviética, famoso por sua atuação na Guerra da Coreia. Combinando alta velocidade, excelente manobrabilidade e poderoso armamento, tornou-se um dos jatos mais temidos do início da Guerra Fria.', 'Desenvolvido pelo escritório de design Mikoyan-Gurevich e introduzido em 1949, o MiG-15 foi criado para dar à União Soviética um caça capaz de rivalizar com as aeronaves a jato ocidentais. Equipado com um motor derivado do britânico Rolls-Royce Nene (produzido sob licença como Klimov VK-1), atingia velocidades próximas de Mach 0,9 e possuía teto de serviço superior a 15.000 metros, um feito impressionante para sua época.\r\n\r\nSeu armamento era especialmente devastador: dois canhões NS-23 de 23 mm e um canhão N-37 de 37 mm, projetados para derrubar bombardeiros pesados. Essa combinação o tornava letal em combates aéreos e contra formações estratégicas da OTAN. O design com asas enflechadas deu ao MiG-15 uma agilidade muito superior à de caças a jato anteriores.\r\n\r\nDurante a Guerra da Coreia (1950–1953), o MiG-15 enfrentou diretamente os F-86 Sabre americanos em combates que ficaram conhecidos como “MiG Alley”. Esses duelos marcaram a primeira grande guerra entre caças a jato, estabelecendo novas táticas e estratégias de combate aéreo.\r\n\r\nProduzido em mais de 12.000 unidades, incluindo versões licenciadas na China e em outros países do Pacto de Varsóvia, o MiG-15 foi um dos caças mais fabricados da história. Ele simbolizou a chegada da União Soviética à era dos jatos e exerceu enorme influência no desenvolvimento de caças posteriores, como o MiG-17 e o MiG-19.', '/uploads/1758565018_058cfd60.jpg', 2, 6, 'published', '2025-09-22 18:16:58', '2025-09-22 18:16:58'),
(12, 'F-86A-5', 'O F-86A-5 Sabre foi uma das primeiras versões operacionais do icônico caça a jato norte-americano F-86. Desenvolvido para superioridade aérea, destacou-se por sua velocidade, manobrabilidade e pelo combate bem-sucedido contra caças soviéticos MiG-15 durante a Guerra da Coreia.', 'O F-86A-5 Sabre entrou em serviço em 1949, sendo uma versão aprimorada do F-86A original, com melhorias no motor General Electric J47-GE-13 e sistemas de controle de voo refinados. Capaz de atingir velocidades próximas a Mach 0,92, possuía teto operacional superior a 14.000 metros, o que lhe permitia operar com eficácia em combates a grande altitude.\r\n\r\nSeu armamento principal consistia em seis metralhadoras M3 Browning de 12,7 mm, eficazes contra caças inimigos e bombardeiros. Algumas versões também podiam carregar bombas ou foguetes para ataques ao solo. O design com asas enflechadas conferia excelente estabilidade e manobrabilidade, tornando o F-86 um rival formidável do MiG-15 no céu da Coreia.\r\n\r\nDurante a Guerra da Coreia (1950–1953), o F-86A-5 participou de inúmeras batalhas aéreas na região conhecida como “MiG Alley”, onde pilotos americanos enfrentaram os MiGs soviéticos e norte-coreanos. Essas batalhas foram fundamentais para o desenvolvimento de táticas de combate a jato, consolidando o Sabre como um dos caças mais eficazes da primeira geração de aeronaves a jato.\r\n\r\nProduzido em milhares de unidades, o F-86A-5 ajudou a estabelecer a supremacia aérea da Força Aérea dos EUA na Guerra da Coreia e influenciou fortemente o desenvolvimento de caças subsequentes, como o F-86F e, posteriormente, a família de caças F-100 Super Sabre.', '/uploads/1758565076_d85e82b2.jpg', 2, 6, 'published', '2025-09-22 18:17:56', '2025-09-22 18:17:56'),
(13, 'Su-30SM', 'O Su-30SM é um caça-bombardeiro de superioridade aérea e múltiplas funções da família Su-30, desenvolvido pela Rússia. Combinando alta manobrabilidade, longo alcance e armamento moderno, é um dos caças mais versáteis e avançados da Força Aérea Russa.', 'O Su-30SM (Flanker-C, em código OTAN) é uma versão modernizada do Su-30, produzida pela Sukhoi e introduzida em 2012. Pesando cerca de 34,5 toneladas em ordem de combate, o avião é equipado com dois motores AL-31FP com pós-combustão e vetoração de empuxo, permitindo manobras de alta complexidade conhecidas como supermanobrabilidade, que superam muitos caças ocidentais em combates aproximados.\r\n\r\nSeu armamento é extremamente variado: um canhão interno GSh-30-1 de 30 mm, mísseis ar-ar como R-77 e R-73, mísseis ar-superfície, bombas guiadas e não guiadas, além de sistemas eletrônicos avançados para guerra eletrônica e contramedidas. Possui ainda radar N011M Bars, capaz de rastrear múltiplos alvos simultaneamente a longas distâncias, tornando-o eficaz em operações de ataque e defesa aérea.\r\n\r\nO Su-30SM é amplamente utilizado em exercícios, patrulhas de fronteira e missões de projeção de poder, incluindo operações no Mar do Japão, Síria e Ártico. Sua versatilidade permite engajar tanto alvos aéreos quanto terrestres ou navais, sendo considerado um caça de quarta geração “+” devido à integração de tecnologias modernas.\r\n\r\nGraças à combinação de alcance, capacidade de carga, eletrônica de ponta e manobrabilidade excepcional, o Su-30SM permanece como um dos caças mais confiáveis e letais em operação no mundo contemporâneo, consolidando a reputação da Rússia na aviação militar moderna.', '/uploads/1758565171_b8c60f37.jpg', 2, 6, 'published', '2025-09-22 18:19:31', '2025-09-22 18:19:31'),
(14, 'Bismarck', 'O Bismarck foi um dos maiores e mais poderosos navios de guerra da Alemanha durante a Segunda Guerra Mundial. Como couraçado de batalha, combinava blindagem pesada, velocidade impressionante e armamento de longo alcance, tornando-se uma ameaça formidável para a Marinha Real Britânica.', 'O Bismarck entrou em serviço em 1940, construído pelo estaleiro Blohm & Voss em Hamburgo. Com deslocamento de cerca de 50.300 toneladas totalmente carregado, possuía oito canhões de 380 mm em quatro torres duplas, capazes de atingir alvos a mais de 35 km de distância. Sua blindagem frontal chegava a 320 mm, tornando-o resistente à maioria dos projéteis inimigos da época.\r\n\r\nProjetado para operar no Atlântico Norte, o Bismarck destacou-se pela combinação de velocidade (cerca de 30 nós) e resistência, permitindo-lhe ameaçar comboios aliados. Sua missão mais famosa ocorreu em maio de 1941, durante a Operação Rheinübung, quando navegou em direção ao Atlântico para atacar navios mercantes britânicos. Durante essa operação, afundou o cruzador HMS Hood, causando grande impacto moral e estratégico para a Marinha Britânica.\r\n\r\nO Bismarck, no entanto, tornou-se alvo prioritário da frota britânica. Após uma intensa perseguição, que incluiu ataques aéreos e navais, o navio foi finalmente afundado em 27 de maio de 1941. Apesar de sua curta carreira, o Bismarck simboliza a engenharia naval alemã da Segunda Guerra Mundial, combinando poder de fogo, blindagem e velocidade em um projeto que marcou a história da guerra naval.', '/uploads/1758565244_62ae8b69.jpg', 2, 8, 'published', '2025-09-22 18:20:44', '2025-09-22 18:20:44'),
(15, 'Yamato', 'O Yamato foi o maior e mais poderoso couraçado da história, construído pelo Império do Japão durante a Segunda Guerra Mundial. Com blindagem quase impenetrável e canhões de calibre gigante, simbolizava o poder naval japonês e a busca por supremacia no Pacífico.', 'O Yamato entrou em serviço em 1941, com deslocamento total de cerca de 72.800 toneladas e comprimento de 263 metros, tornando-se o maior couraçado já construído. Seu armamento principal consistia em nove canhões de 460 mm em três torres triplas, capazes de disparar projéteis de até 1.500 kg a distâncias superiores a 40 km. A blindagem frontal chegava a 410 mm, oferecendo proteção quase total contra qualquer armamento inimigo disponível na época.\r\n\r\nProjetado para enfrentar a marinha americana em combates de grande escala, o Yamato operou principalmente como força de dissuasão e escolta de grandes frotas de ataque. Apesar de seu poder, a supremacia aérea americana e a crescente importância da guerra aérea reduziram seu impacto estratégico. O Yamato participou de poucas operações de combate, sendo mais notório em 1945, na Operação Ten-Go, quando foi enviado em uma missão suicida para Okinawa. Durante essa missão, foi atacado por centenas de aeronaves americanas e acabou afundado em 7 de abril de 1945, com grandes perdas humanas.\r\n\r\nO Yamato permanece como um símbolo do apogeu da engenharia naval japonesa e da filosofia de construção de navios de grande porte com poder de fogo absoluto, representando o fim da era dos couraçados como principal instrumento de guerra naval, substituídos pelos porta-aviões e pelo poder aéreo.', '/uploads/1758565302_a922ffc4.jpg', 2, 8, 'published', '2025-09-22 18:21:42', '2025-09-22 18:21:42'),
(16, 'USS Iowa', 'O USS Iowa foi o primeiro navio da classe Iowa e um dos couraçados mais rápidos e potentes já construídos pelos Estados Unidos. Projetado para combinar velocidade, blindagem e poder de fogo, serviu ativamente durante a Segunda Guerra Mundial e em conflitos posteriores.', 'O USS Iowa (BB-61) entrou em serviço em 1943, com deslocamento de cerca de 58.000 toneladas e comprimento de 270 metros. Seu armamento principal consistia em nove canhões de 406 mm (16 polegadas) dispostos em três torres triplas, complementados por um extenso conjunto de canhões secundários e antiaéreos. A blindagem frontal chegava a 307 mm, protegendo-o contra a maioria dos projéteis inimigos da época, enquanto sua velocidade máxima atingia 33 nós, tornando-o um dos couraçados mais rápidos do mundo.\r\n\r\nO USS Iowa foi projetado para operar em conjunto com porta-aviões e para enfrentar navios de grande porte em combate direto, especialmente no Pacífico, onde participou de escoltas, bombardeios costeiros e apoio a operações anfíbias. Após a Segunda Guerra Mundial, serviu em Guerra da Coreia, Guerra do Vietnã e foi modernizado durante a Guerra Fria, recebendo mísseis Tomahawk e sistemas de defesa aérea modernos.\r\n\r\nGraças à combinação de velocidade, blindagem e poder de fogo, o USS Iowa e seus irmãos da classe Iowa representaram o ápice da engenharia de couraçados americanos, permanecendo ativos por décadas e deixando um legado duradouro na história naval moderna.', '/uploads/1758565656_af6649bb.jpg', 2, 8, 'published', '2025-09-22 18:27:36', '2025-09-22 18:27:36'),
(17, 'HMS Hood', 'O HMS Hood foi o maior e mais rápido cruzador de batalha da Marinha Real Britânica durante a primeira metade do século XX. Reconhecido por sua impressionante velocidade e armamento pesado, simbolizava o poder naval britânico antes da Segunda Guerra Mundial.', 'O HMS Hood entrou em serviço em 1920, com deslocamento de cerca de 42.100 toneladas e comprimento de 262 metros. Seu armamento principal consistia em oito canhões de 381 mm (15 polegadas) em quatro torres duplas, complementados por canhões secundários e antiaéreos. Embora possuísse blindagem mais leve que os couraçados contemporâneos (com blindagem frontal de até 305 mm), sua velocidade máxima de 32 nós permitia manobras táticas rápidas em combate.\r\n\r\nO Hood foi projetado como cruzador de batalha, equilibrando poder de fogo e velocidade para enfrentar navios inimigos, mas não para suportar os impactos diretos de um couraçado moderno. Ele serviu como navio de esquadra e presença diplomática durante o período entre-guerras, além de patrulhar os oceanos para proteger rotas de comércio britânicas.\r\n\r\nDurante a Segunda Guerra Mundial, o HMS Hood participou de diversas operações, incluindo a caçada à frota alemã no Atlântico. Sua missão mais famosa foi a Batalha do Estreito da Dinamarca, em 24 de maio de 1941, contra o Bismarck e o Prinz Eugen. Durante esse confronto, o Hood sofreu um impacto devastador em seu cinturão de blindagem, explodindo e afundando em minutos, com apenas 3 sobreviventes de uma tripulação de 1.418 homens.\r\n\r\nO HMS Hood permanece como um símbolo da tradição naval britânica, lembrado tanto por seu poder quanto pela vulnerabilidade frente aos couraçados modernos, destacando a transição da era dos cruzadores de batalha para os navios mais pesados e protegidos da Segunda Guerra Mundial.', '/uploads/1758566121_770fa91c.jpg', 2, 8, 'published', '2025-09-22 18:35:21', '2025-09-22 18:38:11');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','visitante') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'visitante',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password_hash`, `role`, `created_at`) VALUES
(1, 'rodrigo', 'r@email.com', 'rodrigo', '$2y$10$58hZnae44L9XwBDpyu9JwOBy8dfzc7Ol3ePQqft48GCrOjsO9gDme', 'visitante', '2025-09-21 02:21:39'),
(2, 'Administrador', 'admin@email.com', 'admin', '$2y$10$h52Q4yMVr4M3dHnv4tImNOqq13NA.falyZwo7IbRouScfKtcXMeQa', 'admin', '2025-09-21 17:08:10'),
(3, 'Usuario', 'user@email.com', 'Usuário', '$2y$10$Ht9WjY9wm.6NzVJHwDwcvu/bFOPtVwmUVO4wdEjhFu9Ie04nLM1T.', 'visitante', '2025-09-22 18:36:16');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Índices de tabela `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comments_posts` (`post_id`);

--
-- Índices de tabela `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_posts_users` (`author_id`),
  ADD KEY `fk_posts_categories` (`category_id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_posts` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_posts_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_posts_users` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
