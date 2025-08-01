<?php

    // Classe base para todos os personagens da Vila do Chaves
    abstract class PersonagemVila {
        // Atributos gerais
        public $forca, $defesa, $agilidade, $inteligencia, $vida, $nome_curto, $nome_completo, $img, $descricao;

        // Métodos de ações comuns na Vila
        public function acaoComum() {
            echo('Tentou resolver na conversa (Dano leve / Sucesso moderado) <br>');
        }
        public function esquivar() {
            echo('Desviou da bronca (chance de evitar dano) <br>');
        }
        public function pedirAjuda() {
            echo('Pediu ajuda para um amigo da vila (Pode invocar um aliado ou efeito positivo) <br>');
        }
        public function fugir() {
            echo('Deu no pé para evitar a confusão! <br>');
        }
        
        public function __set($atributo, $valor) {
            $this->$atributo = $valor;
        }

        public function __get($atributo) {
            return $this->$atributo;
        }
    }

    // Personagens da Vila do Chaves (atributos ajustados para máximo 100)

    class SrMadruga extends PersonagemVila {
        public $forca = 60; 
        public $defesa = 40; 
        public $agilidade = 70; 
        public $inteligencia = 80; 
        public $vida = 70;
        public $nome_curto = 'sr_madruga';
        public $nome_completo = 'Sr. Madruga';
        public $img = 'sr_madruga';
        public $descricao = 'O icônico morador do 71, sempre fugindo do Sr. Barriga e das broncas da Dona Florinda. Mestre em arrumar bicos e em filosofar.';

        public function acaoEspecial() {
            echo 'Chute do Professor Girafales (dano médio, chance de atordoar) <br>';
            echo 'Discurso do Chaves (reduz agressividade do oponente) <br>';
        }
    }

    class Popis extends PersonagemVila {
        public $forca = 30; 
        public $defesa = 50; 
        public $agilidade = 60;
        public $inteligencia = 75; 
        public $vida = 65;
        public $nome_curto = 'popis';
        public $nome_completo = 'Popis';
        public $img = 'popis';
        public $descricao = 'A vaidosa sobrinha da Dona Florinda. Adora seu Quico e vive dando patadas, mas tem um bom coração... lá no fundo.';

        public function acaoEspecial() {
            echo 'Pancada com a Boneca (dano baixo, atrai a atenção) <br>';
            echo 'Choro Estridente (reduz moral do inimigo) <br>';
        }
    }

    class Chaves extends PersonagemVila {
        public $forca = 40; 
        public $defesa = 30; 
        public $agilidade = 85; 
        public $inteligencia = 60; 
        public $vida = 50;
        public $nome_curto = 'chaves';
        public $nome_completo = 'Chaves';
        public $img = 'chaves';
        public $descricao = 'O órfão mais famoso da vila, vive dentro de um barril e sempre arruma confusão, mas também tem um coração de ouro.';

        public function acaoEspecial() {
            echo 'Cachete (dano baixo, chance de errar) <br>';
            echo 'Entrar no Barril (aumenta defesa por um turno) <br>';
        }
    }

    class Chapolin extends PersonagemVila {
        public $forca = 100; // Ajustado de 150 para 100
        public $defesa = 100; // Ajustado de 120 para 100
        public $agilidade = 100; // Ajustado de 130 para 100
        public $inteligencia = 100; // Ajustado de 110 para 100
        public $vida = 100; // Ajustado de 200 para 100
        public $nome_curto = 'chapolin';
        public $nome_completo = 'Chapolin Colorado';
        public $img = 'chapolin';
        public $descricao = 'O herói mais atrapalhado, mas com bom coração! Não contava com a sua astúcia para resolver os problemas da vila. Agora, nivelado ao poder máximo!';

        public function acaoEspecial() {
            echo 'Marreta Biônica (dano massivo, chance de nocaute) <br>';
            echo 'Pastilhas Encolhedoras (permite entrar em lugares pequenos, ou fugir mais fácil, com bônus de agilidade) <br>';
        }
    }

    class SrBarriga extends PersonagemVila {
        public $forca = 50; 
        public $defesa = 90; 
        public $agilidade = 20;
        public $inteligencia = 85; 
        public $vida = 100; // Ajustado de 120 para 100
        public $nome_curto = 'sr_barriga';
        public $nome_completo = 'Sr. Barriga';
        public $img = 'sr_barriga';
        public $descricao = 'O proprietário da vila, sempre vindo cobrar o aluguel e apanhando do Chaves. Apesar de tudo, tem um bom coração.';

        public function acaoEspecial() {
            echo 'Boleto de Aluguel (dano mental, pode causar desespero) <br>';
            echo 'Abraço do Ñoño (recupera pouca vida) <br>';
        }
    }

    class DonaFlorinda extends PersonagemVila {
        public $forca = 70; 
        public $defesa = 60; 
        public $agilidade = 50;
        public $inteligencia = 70;
        public $vida = 80;
        public $nome_curto = 'dona_florinda';
        public $nome_completo = 'Dona Florinda';
        public $img = 'dona_florinda';
        public $descricao = 'A brava mãe do Quico, sempre cuidando da sua casa e batendo no Seu Madruga. Adora o Professor Girafales.';

        public function acaoEspecial() {
            echo 'Tapa no Seu Madruga (dano considerável, alta chance de acerto) <br>';
            echo 'Café para o Professor Girafales (aumenta inteligência temporariamente) <br>';
        }
    }

    class DonaClotilde extends PersonagemVila {
        public $forca = 35; 
        public $defesa = 45; 
        public $agilidade = 55;
        public $inteligencia = 95; 
        public $vida = 70;
        public $nome_curto = 'dona_clotilde';
        public $nome_completo = 'Dona Clotilde (Bruxa do 71)';
        public $img = 'dona_clotilde';
        public $descricao = 'A solteirona da vila, conhecida como a "Bruxa do 71" pelas crianças. Loucamente apaixonada pelo Seu Madruga.';

        public function acaoEspecial() {
            echo 'Poção de Amor (confunde o inimigo) <br>';
            echo 'Feitiço do Gato (invoca o Satanás para ajudar no ataque) <br>';
        }
    }
    
    class Satanas extends PersonagemVila {
        public $forca = 100; // Ajustado de 130 para 100
        public $defesa = 100; // Ajustado de 100 (já estava no limite)
        public $agilidade = 100; // Ajustado de 150 para 100
        public $inteligencia = 90; 
        public $vida = 100; // Ajustado de 180 para 100
        public $nome_curto = 'satanas';
        public $nome_completo = 'Gato (Satanás)';
        public $img = 'satanas';
        public $descricao = 'O misterioso gato preto da Dona Clotilde, que as crianças da vila juram ser o Satanás. Agora, uma força mística e ágil, nivelado ao poder máximo!';

        public function acaoEspecial() {
            echo 'Arranhão Místico (dano alto, com chance de causar medo) <br>';
            echo 'Miado Demoníaco (reduz drasticamente a defesa e moral do inimigo) <br>';
        }
    }

    class Godinez extends PersonagemVila {
        public $forca = 25; 
        public $defesa = 30; 
        public $agilidade = 40;
        public $inteligencia = 10; 
        public $vida = 45;
        public $nome_curto = 'godinez';
        public $nome_completo = 'Godinez';
        public $img = 'godinez';
        public $descricao = 'O sobrinho do Professor Girafales, conhecido por sua inexpressividade e por sempre responder "Não sei".';

        public function acaoEspecial() {
            echo 'Ato Inesperado (dano aleatório, pode ser ineficaz) <br>';
            echo 'O Silêncio de Godinez (aumenta sua esquiva por um turno, por ser ignorado) <br>';
        }
    }

    class ProfGirafales extends PersonagemVila {
        public $forca = 40; 
        public $defesa = 50; 
        public $agilidade = 30;
        public $inteligencia = 100; 
        public $vida = 85;
        public $nome_curto = 'prof_girafales';
        public $nome_completo = 'Professor Girafales';
        public $img = 'prof_girafales';
        public $descricao = 'O respeitado Professor Linguiça, sempre elegante e apaixonado pela Dona Florinda. Mestre em ensinamentos e broncas.';

        public function acaoEspecial() {
            echo 'Tacada de Luva (dano moderado, causa indignação) <br>';
            echo 'Lição de Moral (reduz o ataque do inimigo) <br>';
        }
    }

    class Nono extends PersonagemVila {
        public $forca = 55; 
        public $defesa = 80; 
        public $agilidade = 25;
        public $inteligencia = 60;
        public $vida = 100; // Ajustado de 110 para 100
        public $nome_curto = 'nono';
        public $nome_completo = 'Ñoño';
        public $img = 'nono';
        public $descricao = 'O filho do Sr. Barriga, comilão e um pouco bobo, mas sempre com um coração bom. Sua barriga é sua maior defesa.';

        public function acaoEspecial() {
            echo 'Abraço Apertado (dano baixo, pode paralisar por um turno) <br>';
            echo 'Lanche Rápido (recupera vida) <br>';
        }
    }

    class Jaiminho extends PersonagemVila {
        public $forca = 30; 
        public $defesa = 35; 
        public $agilidade = 15; 
        public $inteligencia = 70;
        public $vida = 60;
        public $nome_curto = 'jaiminho';
        public $nome_completo = 'Jaiminho, o Carteiro';
        public $img = 'jaiminho';
        public $descricao = 'O carteiro que odeia a fadiga e sempre busca um banco para descansar. Conhece todos os segredos da vila.';

        public function acaoEspecial() {
            echo 'Entrega Urgente (confunde o inimigo, pode roubar um item) <br>';
            echo 'Soneca Estratégica (recupera vida, mas perde um turno) <br>';
        }
    }

?>