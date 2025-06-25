<?php

    /*
    HERANÇA:
    Poder herdar atributos e métodos de uma classe pai (Modelo)

    POLIMORFISMO:
    Mesmo herdando atributos ou métodos do pai, o filho tem liberdade para
    ter o mesmo atributo ou método diferente do pai;

    */

    abstract class TimeDeFutebol {

        public $nome = null;
        public $pais = null;
        public $fundacao = null;
        public $treinador = null;

        function jogar()
        { echo "O time está jogando uma partida."; }

        function treinar()
        { echo "O time está treinando duro para o próximo jogo."; }

        function contratar()
        { echo "O time busca novos talentos no mercado.";
        }

        function __get($atributo){
            return $this-> $atributo;
        }

        function __set($atributo,$valor){
            $this->$atributo = $valor;
        }

    }

    class TimeBrasileiro extends TimeDeFutebol {
        public $ligaEstadual;

        function contratar()
        { echo "O time brasileiro foca em jogadores sul-americanos."; }
    }


    Class TimeEuropeu extends TimeDeFutebol{
        function contratar()
        { echo "O time europeu busca estrelas globais."; }
    }

    Class TimeLondrino extends TimeEuropeu{
        public $estadio;
    }

    $corinthians = new TimeBrasileiro();
    $realMadrid = new TimeEuropeu();
    $arsenal = new TimeLondrino();

    $corinthians->__set("nome","Corinthians");
    $corinthians->__set("pais","Brasil");
    $corinthians->__set("fundacao","1910");
    $corinthians->__set("treinador","Dorival Júnior");
    $corinthians->__set("liga","Brasileirão");

    echo "<b>Time " . $corinthians->__get("nome") . "</b>";
    echo "<br/>";
    echo "País: " . $corinthians->__get("pais");
    echo "<br/>";
    echo "Ano de Fundação: " . $corinthians->__get("fundacao");
    echo "<br/>";
    echo "Treinador: " . $corinthians->__get("treinador");
    echo "<br/>";
    echo "Liga: " . $corinthians->__get("ligaEstadual");
    echo "<br/>";
    echo $corinthians->contratar();
    echo "<br/>";
    echo $corinthians->jogar();
    echo "<hr>";

    $realMadrid->__set("nome","Real Madrid");
    $realMadrid->__set("pais","Espanha");
    $realMadrid->__set("fundacao","1902");
    $realMadrid->__set("treinador","Xabi Alonso");

    echo "<b>Time " . $realMadrid->__get("nome") . "</b>";
    echo "<br/>";
    echo "País: " . $realMadrid->__get("pais");
    echo "<br/>";
    echo "Ano de Fundação: " . $realMadrid->__get("fundacao");
    echo "<br/>";
    echo "Treinador: " . $realMadrid->__get("treinador");
    echo "<br/>";
    echo $realMadrid->contratar();
    echo "<br/>";
    echo $realMadrid->treinar();
    echo "<hr>";

    $arsenal->__set("nome","Arsenal");
    $arsenal->__set("pais","Inglaterra");
    $arsenal->__set("fundacao","1886");
    $arsenal->__set("treinador","Mikel Arteta");
    $arsenal->__set("estadio","Emirates Stadium");

    echo "<b>Time " . $arsenal->__get("nome") . "</b>";
    echo "<br/>";
    echo "País: " . $arsenal->__get("pais");
    echo "<br/>";
    echo "Ano de Fundação: " . $arsenal->__get("fundacao");
    echo "<br/>";
    echo "Treinador: " . $arsenal->__get("treinador");
    echo "<br/>";
    echo "Estádio: " . $arsenal->__get("estadio");
    echo "<br/>";
    echo $arsenal->contratar();
    echo "<br/>";
    echo $arsenal->jogar();
    echo "<hr>";

?>