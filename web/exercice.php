<?php
include('config.php');
?>
<!DOCTYPE html>
<html>
<body class="text-center">
  <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal body -->
        <div id="modal" class="modal-body">
          <img id="etoiles" src="<?=$racine;?>etoiles.png" alt="#">
          <h4 class="modal-title">EXCELLENT</h4>
          <p>Tu es un champion !</p>
          <div class="bouttonContainer">
            <button type="button" id="menu" class="btn btn-primary" data-dismiss="modal">Menu</button>
            <button id="newGame" data-dismiss="modal" type="button">Continuer</button>
            <button type="button" id="again" class="btn btn-warning" data-dismiss="modal">Recommence</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- The Modal -->
  <div class="modal" id="perdu">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal body -->
        <div id="modal" class="modal-body">
          <img id="etoiles" src="<?=$racine;?>etoiles.png" alt="#">
          <h4 class="modal-title">PERDU</h4>
          <p>Domage, retente ta chance</p>
          <div class="bouttonContainer">
            <button type="button" id="menu" class="btn btn-primary" data-dismiss="modal">Menu</button>
            <a href="#" id="newGame" data-dismiss="modal">
              <img src="#" alt="#">
            </a>

            <button type="button" id="again" class="btn btn-warning" data-dismiss="modal">Recommence</button>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div>
    <header>
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand" href="<?=$_SERVER['HTTP_REFERER'];?>"><i style="font-size: 25px;" class="fa fa-chevron-left" aria-hidden="true"></i></a>
          </div>
          <div class="nav navbar-nav navbar-right">
            <a class="navbar-brand" href="<?=$racine;?>home/"><i style="font-size: 25px;" class="fa fa-home" aria-hidden="true"></i></a>
          </div>
        </div>
      </nav>
    </header>

    <main role="main" class="inner cover">
      <h3 class="cover-heading">Telmi le peroquet</h3>
      <p class="lead">Dans ce mini-jeu repete tout ce que dit Telmi</p>
      <h4 class="Mot">Répéte après moi :</h4>
      <p id="keyword"></p>

      <p class="lead commande">
        <button href="#" class="btn btn-lg btn-secondary" id="startBtn">A toi de jouer</button>
        <button href="#" class="btn btn-lg btn-secondary" id="stopBtn" disabled>J'ai terminé</button>
      </p>


      <span id="statusDiv"></span>
      <span id="hypothesisDiv"></span>

      <div class="result">
        <p>Résultat de ta diction :</p>
        <p id="phraseDiv" style="display: none;"></p>
      </div>
    </main>
  </div>
  <!-- SDK REFERENCE -->
  <script src="<?=$racine;?>js/speech.sdk.bundle.js"></script>

  <!-- SDK USAGE -->
  <script>

        // Setup the recognizer
        function RecognizerSetup(SDK, recognitionMode, language, format, subscriptionKey) {

          // Mode de dicter ici en dictation
          recognitionMode = SDK.RecognitionMode.Dictation;

          var recognizerConfig = new SDK.RecognizerConfig(
            new SDK.SpeechConfig(
              new SDK.Context(
                new SDK.OS(navigator.userAgent, "Browser", null),
                new SDK.Device("SpeechSample", "SpeechSample", "1.0.00000")
                )
              ),
            recognitionMode,
            language,
            format
            );


          var useTokenAuth = false;

          var authentication = function() {
            if (!useTokenAuth)
              return new SDK.CognitiveSubscriptionKeyAuthentication(subscriptionKey);

            var callback = function() {
              var tokenDeferral = new SDK.Deferred();
              try {
                var xhr = new(XMLHttpRequest || ActiveXObject)('MSXML2.XMLHTTP.3.0');
                xhr.open('GET', '/token', 1);
                xhr.onload = function () {
                  if (xhr.status === 200)  {
                    tokenDeferral.Resolve(xhr.responseText);
                  } else {
                    tokenDeferral.Reject('Issue token request failed.');
                  }
                };
                xhr.send();
              } catch (e) {
                        //window.console && console.log(e);
                        tokenDeferral.Reject(e.message);
                      }
                      return tokenDeferral.Promise();
                    }

                    return new SDK.CognitiveTokenAuthentication(callback, callback);
                  }();

                  return SDK.CreateRecognizer(recognizerConfig, authentication);
                }

        // Start the recognition
        function RecognizerStart(SDK, recognizer) {
          recognizer.Recognize((event) => {

            switch (event.Name) {
              case "RecognitionTriggeredEvent" :
              UpdateStatus("Je me prépare");
              break;
              case "ListeningStartedEvent" :
              UpdateStatus("Je t'écoute");
              break;
              case "RecognitionStartedEvent" :
              UpdateStatus("J'analyse");
              break;
              case "SpeechStartDetectedEvent" :
              UpdateStatus("Je te reconais");
                        //console.log(JSON.stringify(event.Result)); // check console for other information in result
                        break;
                        case "SpeechHypothesisEvent" :
                        UpdateRecognizedHypothesis(event.Result.Text, false);
                        //console.log(JSON.stringify(event.Result)); // check console for other information in result
                        break;
                        case "SpeechFragmentEvent" :
                        UpdateRecognizedHypothesis(event.Result.Text, true);
                        //console.log(JSON.stringify(event.Result)); // check console for other information in result
                        break;
                        case "SpeechEndDetectedEvent" :
                        OnSpeechEndDetected();
                        UpdateStatus("Finalisation");
                        //console.log(JSON.stringify(event.Result)); // check console for other information in result
                        break;
                        case "SpeechSimplePhraseEvent" :
                        UpdateRecognizedPhrase(JSON.stringify(event.Result, null, 3));
                        break;
                        case "SpeechDetailedPhraseEvent" :
                        UpdateRecognizedPhrase(JSON.stringify(event.Result, null, 3));
                        break;
                        case "RecognitionEndedEvent" :
                        OnComplete();
                        UpdateStatus("En attente");
                        //console.log(JSON.stringify(event)); // Debug information
                        break;
                        default:
                        //console.log(JSON.stringify(event)); // Debug information
                      }
                    })
          .On(() => {
                // The request succeeded. Nothing to do here.
              },
              (error) => {
                //console.error(error);
              });
        }

        // Stop the Recognition.
        function RecognizerStop(SDK, recognizer) {
            // recognizer.AudioSource.Detach(audioNodeId) can be also used here. (audioNodeId is part of ListeningStartedEvent)
            recognizer.AudioSource.TurnOff();
          }
        </script>

        <!-- Browser Hooks -->
        <script>
          var startBtn, stopBtn, hypothesisDiv, phraseDiv, statusDiv;
          var key,formatOptions, recognitionMode, inputSource, filePicker;
          var SDK;
          var recognizer;
          var previousSubscriptionKey;

          document.addEventListener("DOMContentLoaded", function () {
            createBtn = document.getElementById("createBtn");
            startBtn = document.getElementById("startBtn");
            stopBtn = document.getElementById("stopBtn");
            phraseDiv = document.getElementById("phraseDiv");
            hypothesisDiv = document.getElementById("hypothesisDiv");
            statusDiv = document.getElementById("statusDiv");
            newGame = document.getElementById("newGame");
            keyword = document.getElementById("keyword");



            startBtn.addEventListener("click", function () {
                    //On lance l'appel à l'API-


                    Setup();

                    hypothesisDiv.innerHTML = "";
                    phraseDiv.innerHTML = "";
                    RecognizerStart(SDK, recognizer);
                    startBtn.disabled = true;
                    stopBtn.disabled = false;
                  });

            newGame.addEventListener("click", function () {
                    //On lance l'appel à l'API

                    Setup();
                    hypothesisDiv.innerHTML = "";
                    phraseDiv.innerHTML = "";
                    RecognizerStart(SDK, recognizer);
                    startBtn.disabled = true;
                    stopBtn.disabled = false;
                  });


            stopBtn.addEventListener("click", function () {
              RecognizerStop(SDK, recognizer);
              startBtn.disabled = false;
              stopBtn.disabled = true;
            });
          });

          var i = -1;
          var tabmotatrouver = ["chat","voiture","chien","soleil","jupiter","moto","arbre","fleure","poule","montagne","jordan","emeric","erwin","baptiste","raphael"];
          var motatrouver = "";

          function Setup(motatrouver) {
            i++;
            var motatrouver = tabmotatrouver[i];
            keyword.innerHTML = motatrouver;

            if (recognizer != null) {
              RecognizerStop(SDK, recognizer);
            }
            recognizer = RecognizerSetup(SDK, "Interactive", "fr-FR", SDK.SpeechResultFormat["Simple"], "4099207d610e451ca7680dff6273324b");
          }

          function UpdateStatus(status) {
            statusDiv.innerHTML = status;
          }

          function UpdateRecognizedHypothesis(text, append) {
            if (append)
              hypothesisDiv.innerHTML += text + " ";
            else
              hypothesisDiv.innerHTML = text;

            var length = hypothesisDiv.innerHTML.length;
            if (length > 403) {
              hypothesisDiv.innerHTML = "..." + hypothesisDiv.innerHTML.substr(length-400, length);
            }
          }

          function OnSpeechEndDetected() {
            stopBtn.disabled = true;
          }

          function UpdateRecognizedPhrase(json, resultat) {

            hypothesisDiv.innerHTML = "";
            phraseDiv.innerHTML += json + "\n";
            //Découpage du json
            var obj = JSON.parse(json);
            //Sort du result
            resultat=obj.DisplayText;


            var motatrouver = keyword.innerHTML;

            // console.log(motatrouver);
            // console.log(resultat);

            //Minusculatitationtion du result
            if (resultat != undefined){
              resultat=resultat.toLowerCase();
              //Mot à trouver

              //Recherche identique mot à trouver et resultat
              var pos = resultat.indexOf(motatrouver[i]);
              if (pos >= 0) {
                  // le mot est trouvé à la position 'pos'
                  $('#myModal').modal('show');
                  RecognizerStop(SDK, recognizer);
                } else {
                  $('#perdu').modal('show');
                  RecognizerStop(SDK, recognizer);
                }
              }
            }

            function OnComplete() {
              startBtn.disabled = false;
              stopBtn.disabled = true;
            }
          </script>

        </body>
        </html>
