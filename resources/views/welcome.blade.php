@extends('layouts.main')

@section('content')
<div class="container">
    <h3>Calcul de la Prime de Garantie</h3>

    <form id="primeForm">
        @csrf
        <div class="mb-3">
            <label class="form-label">Code Produit :</label>
            <input type="text" class="form-control" id="CodeProduit" name="CodeProduit" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Code Garantie :</label>
            <input type="text" class="form-control" id="codeGarantie" name="codeGarantie" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Code Périodicité :</label>
            <input type="text" class="form-control" id="codePeriodicite" name="codePeriodicite" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Durée Cotisation :</label>
            <input type="number" class="form-control" id="duree" name="duree" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Capital Souscrit :</label>
            <input type="text" class="form-control" id="capitalSouscrit" name="capitalSouscrit" required>
        </div>

        {{-- <div class="mb-3">
            <label class="form-label">Date de Naissance :</label>
            <input type="date" class="form-control" id="dateNaissance" name="dateNaissance" required>
        </div> --}}
        
        <div class="mb-3">
            <label class="form-label">Âge Calculé :</label>
            <input type="number" class="form-control" id="age" name="age">
        </div>

        <div class="mb-3">
            <label class="form-label">Date d'effet :</label>
            <input type="date" class="form-control" id="dateEffet" name="dateEffet" required>
        </div>

        <button type="submit" class="btn btn-primary">Calculer</button>
    </form>

    <div class="mt-4">
        <h4>Résultat :</h4>
        <p id="result" class="alert alert-info d-none"></p>
    </div>
</div>
<script>
// document.addEventListener("DOMContentLoaded", function () {
//     document.getElementById("primeForm").addEventListener("submit", function (e) {
//         e.preventDefault(); // Empêcher la soumission classique du formulaire

//         let formData = new FormData(this);

//         fetch("https://api.yakoafricassur.com/enov/prime-garantie", {
//             method: "POST",
//             body: formData
//         })
//         .then(response => {
//             console.log("Réponse brute:", response);
//             return response.json(); // Convertir la réponse en JSON
//         })
//         .then(data => {
//             const reversedData = data.reverse();
//             console.log("reverse data" , reversedData)
//             console.log("Données reçues :", data); // Vérifier la structure des données

//             let resultDiv = document.getElementById("result");

//             if (!data || data.error) {
//                 let message = data && data.message ? data.message : "Réponse vide de l'API.";
//                 resultDiv.textContent = "Erreur : " + message;
//                 resultDiv.classList.replace("alert-info", "alert-danger");
//             } else {
//                 if (Array.isArray(data.primeGarantie)) {
//                     resultDiv.innerHTML = "<strong>Primes Garantie :</strong><br>";
//                     data.primeGarantie.forEach(prime => {
//                         resultDiv.innerHTML += `<p>${JSON.stringify(prime, null, 2)}</p>`;
//                     });
//                 } else {
//                     resultDiv.textContent = "Prime Garantie : " + JSON.stringify(data.primeGarantie, null, 2);
//                 }
//                 resultDiv.classList.replace("alert-danger", "alert-info");
//             }
//             resultDiv.classList.remove("d-none");
//         })
//         .catch(error => {
//             console.error("Erreur lors de la requête :", error);
//             document.getElementById("result").textContent = "Erreur lors de la connexion à l'API : " + error.message;
//             document.getElementById("result").classList.replace("alert-info", "alert-danger");
//             document.getElementById("result").classList.remove("d-none");
//         });
//     });
// });

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("primeForm").addEventListener("submit", function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        fetch("https://api.yakoafricassur.com/enov/prime-garantie", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log("Données reçues :", data);
            let resultDiv = document.getElementById("result");

            if (!data || data.error) {
                let message = data && data.message ? data.message : "Réponse vide de l'API.";
                resultDiv.textContent = "Erreur : " + message;
                resultDiv.classList.replace("alert-info", "alert-danger");
            } else {
                if (Array.isArray(data) && data.length > 0) {
                    
                    let firstRecord = data[0];

                    resultDiv.innerHTML = `<strong>Premier Enregistrement :</strong><br>
                        <p>${JSON.stringify(firstRecord, null, 2)}</p>`;
                } else {
                    resultDiv.textContent = "Aucun enregistrement trouvé.";
                }
                resultDiv.classList.replace("alert-danger", "alert-info");
            }
            resultDiv.classList.remove("d-none");
        })
        .catch(error => {
            console.error("Erreur lors de la requête :", error);
            document.getElementById("result").textContent = "Erreur lors de la connexion à l'API : " + error.message;
            document.getElementById("result").classList.replace("alert-info", "alert-danger");
            document.getElementById("result").classList.remove("d-none");
        });
    });
});


</script>


{{-- <form id="primesCapitalForm">
    <div class="mb-3">
        <label class="form-label">Code Produit :</label>
        <input type="text" class="form-control" id="codeProduit" name="codeProduit" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Code Garantie (optionnel) :</label>
        <input type="text" class="form-control" id="codeGarantie" name="codeGarantie">
    </div>
    <div class="mb-3">
        <label class="form-label">Code Produit Formule (optionnel) :</label>
        <input type="text" class="form-control" id="codeProduitFormule" name="codeProduitFormule">
    </div>
    <button type="submit" class="btn btn-primary">Obtenir Primes Capital</button>
</form>

<div id="result" class="alert alert-info d-none"></div>

<table class="table table-bordered mt-3 d-none" id="resultTable">
    <thead>
        <tr>
            <th>Code Produit</th>
            <th>Garantie</th>
            <th>Prime Capital</th>
        </tr>
    </thead>
    <tbody id="resultBody"></tbody>
</table>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("primesCapitalForm").addEventListener("submit", function (e) {
        e.preventDefault(); // Empêche la soumission classique du formulaire

        let codeProduit = document.getElementById("codeProduit").value;
        let codeGarantie = document.getElementById("codeGarantie").value;
        let codeProduitFormule = document.getElementById("codeProduitFormule").value;

        let apiUrl = `https://api.yakoafricassur.com/enov/primes-capital/${codeProduit}`;
        if (codeGarantie) apiUrl += `?codeGarantie=${codeGarantie}`;
        if (codeProduitFormule) apiUrl += `&codeProduitFormule=${codeProduitFormule}`;

        fetch(apiUrl, {
            method: "GET"
        })
        .then(response => response.json())
        .then(data => {
            console.log(data); // Vérifier la structure de la réponse dans la console

            let resultDiv = document.getElementById("result");
            let resultTable = document.getElementById("resultTable");
            let resultBody = document.getElementById("resultBody");

            if (data.error) {
                resultDiv.textContent = "Erreur : " + data.message;
                resultDiv.classList.replace("alert-info", "alert-danger");
                resultDiv.classList.remove("d-none");
                resultTable.classList.add("d-none");
            } else {
                resultBody.innerHTML = ""; // Vider le tableau avant d'afficher les nouvelles données
                
                if (Array.isArray(data)) { // Vérifier si la réponse est une liste d'objets
                    data.forEach(item => {
                        let row = `<tr>
                            <td>${codeProduit}</td>
                            <td>${item.capital || 'Inconnu'}</td>
                            <td>${item.libelle || '0'}</td>
                        </tr>`;
                        resultBody.innerHTML += row;
                    });

                    resultTable.classList.remove("d-none"); // Afficher le tableau
                    resultDiv.classList.add("d-none"); // Cacher le message de résultat
                } else {
                    resultDiv.textContent = "Résultat : " + JSON.stringify(data, null, 2);
                    resultDiv.classList.replace("alert-danger", "alert-info");
                    resultDiv.classList.remove("d-none");
                    resultTable.classList.add("d-none");
                }
            }
        })
        .catch(error => {
            console.error("Erreur lors de la requête :", error);
            let resultDiv = document.getElementById("result");
            resultDiv.textContent = "Erreur lors de la connexion à l'API.";
            resultDiv.classList.replace("alert-info", "alert-danger");
            resultDiv.classList.remove("d-none");
        });
    });
});
</script> --}}

@endsection
