<!DOCTYPE html>
<php lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="fontawesome/css/all.css" rel="stylesheet" />
  <script defer src="fontawesome/js/all.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="app.css" />
  <title>Document</title>
</head>

<body>
  <div class="wrapper">
    <nav id="sidebar">
      <div class="sidebar-header">
        <h3><i class="fas fa-share-alt"></i>Modellek</h3>
      </div>

      <ul class="list-unstyled components" style="display: block;">
        <li>
          <a href="#"><i class="fas fa-newspaper"></i>Hetilap</a>
        </li>
        <li>
          <a href="#"><i class="fas fa-globe-europe"></i>Online</a>
        </li>
        <li>
          <a href="#"><i class="fas fa-link"></i>Hetilap + Online</a>
        </li>
        <div class="sidebar-header">
          <h3><i class="fas fa-tags"></i>Demó</h3>
        </div>
        <li>
          <a href="#"><i class="fas fa-user-tag"></i>Cimkéző</a>
        </li>
        <li>
          <a href="#"><i class="fas fa-cogs"></i>Tanító</a>
        </li>
      </ul>

      <div class="container-fluid container-collapse-btn">
        <button type="button" id="collapse-button" class="btn btn-collapse">
          <i class="fas fa-angle-left fa-lg"></i>
        </button>
      </div>
    </nav>

    <div class="container-fluid content pt-2 px-4">

      <?php

      $array = explode("\n", file_get_contents('data.txt'));

      for ($i = 0; $i < count($array); $i++) {
        $array[$i] = explode("$$$", $array[$i]);
      }

      //var_dump($array[0][0]) ezzel lehet tesztelni, azért van kikommentezve

      ?>
      <h1>Címkeajánló</h1>
      <form action="">
        <div class="form-row">
          <div class="form-group col-10">
            <label for="">Cikkek Listaja:</label>
            <select id="select-title" class="form-control">
              <?php $i = 0; ?>
              <?php foreach ($array as $item) { ?> <option value="<?php echo $item[4] ?>" style="display: none;" class="option-title" id="<?php echo $i;
                                                                                                                                        $i++; ?>"><?php echo $item[3] ?></option> <?php } ?>
            </select>
          </div>
          <div class="btn-group col-2">
            <button id="button-start" type="button" class="btn btn-danger" onclick="first20()"><i class="fas fa-angle-double-left"></i></button>
            <button id="button-previous" type="button" class="btn btn-danger" onclick="previous20()"><i class="fas fa-angle-left"></i></button>
            <button id="button-next" type="button" class="btn btn-danger" onclick="next20()"><i class="fas fa-angle-right"></i></button>
            <button id="button-end" type="button" class="btn btn-danger" onclick="last20()"><i class="fas fa-angle-double-right"></i></button>
          </div>
        </div>
      </form>

      <form action="">
        <div class="form-row">
          <div class="form-group col-10">
            <div class="input-group">
              <label for="range">Valoszinuseg: <span id="range-value"></span></label>
              <div><input id="min" type="checkbox" /><label>min. 3</label></div>
            </div>

            <input type="range" class="form-control-range" id="range" min="0" max="1" step="0.01" />
          </div>
          <div class="form-group col-2 d-flex flex-column pt-1">
            <label for="range">P: <span>1</span></label>
            <label for="range">R: <span>1</span></label>
          </div>
        </div>
      </form>

      <div class="row container-main">
        <div class="col-6">
          <div class="card h-100">
            <h5 class="card-header">Cikk szövege</h5>
            <div class="card-body">
              <p id="text-content" class="card-text">

              </p>
            </div>
          </div>
        </div>

        <div class="col-6">
          <div class="row mb-4">
            <div class="col-12">
              <div class="card w-100 h-100 container-card-left">
                <div class="title-label">
                  <h5 class="card-header title-top">Eredeti címkék</h5>
                  <p id="text-content" class="card-text">

              </p>
                  <h5 class="card-header title-top">Ajánlott címkék</h5>
                </div>

                <div class="card-body list-label">
                  <ul id="original-labels" class="list-top">
                    <li style="display:none"> </li>
                  </ul>
                  <ul id="recommended-labels" class="list-top">

                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-12">
              <div class="card w-100 h-100 container-card-left">
                <div class="title-label">
                  <h5 class="card-header title-bottom-first">Eredeti címkék (egyéb)</h5>
                  <h5 class="card-header title-bottom-second">Ajánlott címkék (egyéb)</h5>
                </div>

                <div class="card-body list-label">
                  <ul id="original-spec-labels" class="list-bottom-first">

                  </ul>
                  <ul id="recommended-spec-labels" class="list-bottom-second">

                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 mt-4">
        <div class="row">
          <div class="col-3 article-blue">
            <div class="card w-100 h-100">
              <div class="card-body container-statistic">
                <div class="list-data">
                  <h5 class="card-title mb-1">Hetilap</h5>
                  <ul>
                    <li>cikk: <span>110 ezer</span></li>
                    <li>címke: <span>1023 db</span></li>
                    <li>token: <span>73 millió</span></li>
                    <li>type: <span>62 ezer</span></li>
                  </ul>
                </div>
                <i class="fas fa-3x fa-clipboard-list"></i>
              </div>
            </div>
          </div>

          <div class="col-3 article-red">
            <div class="card w-100 h-100">
              <div class="card-body container-statistic">
                <div class="list-data">
                  <h5 class="card-title mb-1">Hetilap +</h5>
                  <ul>
                    <li>cikk: <span>110 ezer</span></li>
                    <li>címke: <span>26901 db</span></li>
                    <li>token: <span>73 millió</span></li>
                    <li>type: <span>36 ezer</span></li>
                  </ul>
                </div>
                <i class="fas fa-3x fa-clipboard-list"></i>
              </div>
            </div>
          </div>

          <div class="col-3 article-orange">
            <div class="card w-100 h-100">
              <div class="card-body container-statistic">
                <div class="list-data">
                  <h5 class="card-title mb-1">Online</h5>
                  <ul>
                    <li>cikk: <span>80 ezer</span></li>
                    <li>címke: <span>76654 db</span></li>
                    <li>token: <span>35 millió</span></li>
                    <li>type: <span>33 ezer</span></li>
                  </ul>
                </div>
                <i class="fas fa-3x fa-clipboard-list"></i>
              </div>
            </div>
          </div>

          <div class="col-3 article-green">
            <div class="card w-100 h-100">
              <div class="card-body container-statistic">
                <div class="list-data">
                  <h5 class="card-title mb-1">Hetilap + Online</h5>
                  <ul>
                    <li>cikk: <span>195 ezer</span></li>
                    <li>címke: <span>104432 db</span></li>
                    <li>token: <span>112 millió</span></li>
                    <li>type: <span>38 ezer</span></li>
                  </ul>
                </div>
                <i class="fas fa-3x fa-clipboard-list"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer>Project &middot; 2020</footer>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <script src="app.js"></script>

  <script type="text/javascript">
    var mytextbox = document.getElementById('text-content');
    var mydropdown = document.getElementById('select-title');

    var myoption = document.getElementsByClassName('option-title');

    // alap 20
    var i;
    var meddig = 20;
    for (i = 0; i < meddig; i++) {
      myoption[i].style.display = 'block';
    }


    //  következő 20
    function next20() {
      meddig = meddig + 20;
      var mettol = meddig - 20;
      if (mettol > myoption.length || meddig > myoption.length) {

        meddig = myoption.length - 20;
        mettol = myoption.length - 20;
        alert("Itt a vége, nincs több.");
      } else {

        for (i = mettol; i < meddig; i++) {
          myoption[i].style.display = 'block';
        }

        var i;
        for (i = 0; i < mettol; i++) {
          myoption[i].style.display = 'none';
        }
      }
    }

    // előző 20
    function previous20() {
      meddig = meddig - 20;
      mettol = meddig - 20;
      console.log(mettol);
      if (meddig < 0 || mettol < 0) {
        mettol = 0;
        meddig = 20;
        alert("ez a vége");
      } else {
        for (i = mettol; i < meddig; i++) {
          myoption[i].style.display = 'block';
          console.log(myoption[i].id);
        }
        for (i = meddig; i < myoption.length; i++) {
          myoption[i].style.display = 'none';
        }
      }
    }

    //utolsó 20
    function last20() {
      meddig = myoption.length;
      mettol = myoption.length - 20;

      for (i = mettol; i < meddig; i++) {
        myoption[i].style.display = 'block';
        console.log(myoption[i].id);
      }

      for (i = 0; i < mettol; i++) {
        myoption[i].style.display = 'none';
      }
    }

    //első 20
    function first20() {
      meddig = 20;
      mettol = 0;
      for (i = 0; i < meddig; i++) {
        myoption[i].style.display = 'block';
      }
      for (i = meddig; i < myoption.length; i++) {
        myoption[i].style.display = 'none';
      }
    }

    mydropdown.onchange = function() {
      mytextbox.value = mytextbox.value + this.value; //to appened
      mytextbox.innerHTML = this.value;
    }
  </script>

</body>

</php>
