<?php

    // MODELO
    //class Carro {

        // ATRIBUTOS
        //public $marca;
        //public $modelo;
        //public $ano;
       // public $cor;
       // public $velocidadeMaxima;

        // MÉTODOS
        //public function exibirDetalhes() {
           // return
               // "Marca: $this->marca <br>
              //  Modelo: $this->modelo <br>
               // Ano: $this->ano <br>
               // Cor: $this->cor <br>
              //  Velocidade Máxima: $this->velocidadeMaxima km/h <hr>";
       // }

       // public function alterarDetalhes($marca, $modelo, $ano, $cor, $velocidadeMaxima) {
        //    $this->marca = $marca;
       //     $this->modelo = $modelo;
       //     $this->ano = $ano;
       //     $this->cor = $cor;
       //     $this->velocidadeMaxima = $velocidadeMaxima;
       // }
   // }

   // $nivus = new Carro();
   // $jetta = new Carro();
  //  $creta = new Carro();

   // $nivus->alterarDetalhes('Volkswagen', 'Nivus', 2024, 'Azul', 180);
   // $jetta->alterarDetalhes('Volkswagen', 'Jetta', 2018, 'Branco', 210);
   // $creta->alterarDetalhes('Hyundai', 'Creta', 2021, 'Branco', 190);

   // echo $nivus->exibirDetalhes();
   // echo $jetta->exibirDetalhes();
   // echo $creta->exibirDetalhes();

?>

<?php

    // MODELO
   // class Carro {
    
   //     // ATRIBUTOS
   //     public $marca = null;
   //     public $modelo = null;
  //      public $ano = null;
  //      public $cor = null;
   //     public $velocidadeMaxima = null;
   //     public $tipoCombustivel = null;
   //     public $portas = null;
    //    public $cambio = null;
//
  //      // MÉTODOS
   //     function setMarca($marca){
  //          $this->marca = $marca;
   //     }
//
    //    function getMarca(){
   //         return $this->marca;
    //    }
//
    //    function exibirDetalhes() {
   //         return "$this->marca $this->modelo, ano $this->ano";
   //     }
//
   //     function setAno($ano){
  // //         $this->ano = $ano;
   //     }
//
  //      function __set($atributo, $valor){
   //         $this->$atributo = $valor;
   //     }

   //     function __get($atributo){
   //         return $this->$atributo;
   //     }

   //     function getAno(){
   //         return $this->ano;
   //     }
   // }

    // Criando um carro usando a Classe (modelo) Carro
   // $nivus = new Carro();

   // $nivus->setMarca("Volkswagen");
   // $nivus->setAno(2024);
   // $nivus->__set("modelo","Nivus");
  //  $nivus->__set("cor","Prata");
   // $nivus->__set("velocidadeMaxima",180);

   // echo "Detalhes do Carro Nivus: </br>";
   // echo $nivus->exibirDetalhes();
    //echo "</br>";

   // echo $nivus->getMarca() . " " . $nivus->__get("modelo") . " é do ano " . $nivus->getAno();
   // echo "</br>";

   // echo "Sua cor é " . $nivus->__get("cor") . " e atinge " . $nivus->__get("velocidadeMaxima") . " km/h<hr>";

   // $jetta = new Carro();
  //  echo "Detalhes do Carro Jetta: </br>";
   // $jetta->__set("marca","Volkswagen");
   // $jetta->__set("modelo","Jetta");
   // $jetta->__set("ano",2023);
  //  $jetta->__set("cor","Branco");
  //  $jetta->__set("tipoCombustivel","Gasolina");

  //  echo "Carro: </br>";
  //  echo $jetta->__get("marca") . " " . $jetta->__get("modelo") . " é do ano " . $jetta->__get("ano") . "</br>";
  //  echo "Cor: " . $jetta->__get("cor") . ", e usa " . $jetta->__get("tipoCombustivel");

  //  $creta = new Carro();
  //  $creta->__set("marca","Hyundai");
  //  $creta->__set("modelo","Creta");
  //  $creta->__set("cor","Azul");
  //  $creta->__set("portas",4);
  //  $creta->__set("cambio","Automático");
  //  echo "<hr>";
  //  echo "Detalhes do Carro Creta: </br>";
  // echo $creta->__get("marca") . " " . $creta->__get("modelo") . ", cor " . $creta->__get("cor") . ", possui " . $creta->__get("portas") . " portas e câmbio " . $creta->__get//("cambio");

?>



<?php

    // Classe que representa um carro.
    class Carro {

        // Atributos do carro.
        public $marca;
        public $modelo;
        public $ano;
        public $cor;
        public $velocidadeMaxima;

        // Método mágico para definir valores aos atributos.
        function __set($atributo, $valor){
            $this->$atributo = $valor;
        }

        // Método mágico para obter valores dos atributos.
        function __get($atributo){
            return $this->$atributo;
        }

        // Método que retorna uma string com os detalhes do carro.
        function exibirDetalhes() {
            return
                "Marca: {$this->__get('marca')} <br>
                Modelo: {$this->__get('modelo')} <br>
                Ano: {$this->__get('ano')} <br>
                Cor: {$this->__get('cor')} <br>
                Velocidade Máxima: {$this->__get('velocidadeMaxima')} km/h <hr>";
        }
    }

    // Criando instâncias da classe Carro.
    $nivus = new Carro();
    $jetta = new Carro();
    $creta = new Carro();

    // Definindo os detalhes para cada carro.
    $nivus->__set('marca', 'Volkswagen');
    $nivus->__set('modelo', 'Nivus');
    $nivus->__set('ano', 2024);
    $nivus->__set('cor', 'Azul');
    $nivus->__set('velocidadeMaxima', 180);

    $jetta->__set('marca', 'Volkswagen');
    $jetta->__set('modelo', 'Jetta');
    $jetta->__set('ano', 2018);
    $jetta->__set('cor', 'Branco');
    $jetta->__set('velocidadeMaxima', 210);

    $creta->__set('marca', 'Hyundai');
    $creta->__set('modelo', 'Creta');
    $creta->__set('ano', 2021);
    $creta->__set('cor', 'Branco');
    $creta->__set('velocidadeMaxima', 190);

    // Exibindo os detalhes de cada carro.
    echo $nivus->exibirDetalhes();
    echo $jetta->exibirDetalhes();
    echo $creta->exibirDetalhes();

?>