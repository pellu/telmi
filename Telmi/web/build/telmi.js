<!-- SDK USAGE -->


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
            console.error(error);
        });
    }

    // Stop the Recognition.
    function RecognizerStop(SDK, recognizer) {
        // recognizer.AudioSource.Detach(audioNodeId) can be also used here. (audioNodeId is part of ListeningStartedEvent)
        recognizer.AudioSource.TurnOff();
    }

<!-- Browser Hooks -->
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

        console.log(motatrouver);
        console.log(resultat);

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
