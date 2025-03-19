document.addEventListener("DOMContentLoaded", function () {
    const produitCode = document.getElementById("produitCode");
    const primeSouhaite = document.getElementById("primepricipale");

    primeSouhaite.addEventListener("change", function () {
        const primeValue = parseFloat(primeSouhaite.value);
        const produitValue = produitCode.value;

        console.log(primeValue);
        console.log(produitValue);

        if (produitValue === "PFA_IND") { 
            // Pour la garantie SECU
            const primeSecu = primeValue * 0.6; 
            const primeGarantieSecur = primeSecu;
            document.getElementById("display-prime-garantie-secu").textContent = primeGarantieSecur;
            document.getElementById("garantiessecu").value = primeGarantieSecur;
            // console.log("Prime sécurité :", primeSecu);

            // Pour la garantie PERF
            const primePerf = primeValue * 0.4; 
            const primeGarantiePerf = primePerf;
            document.getElementById("display-prime-garantie-PERF").textContent = primeGarantiePerf;
            document.getElementById("garantiesperf").value = primeGarantiePerf;
            // console.log("Prime performance :", primePerf);

            document.getElementById("display-prime-final").textContent = primeSecu + primePerf;
        }
    });
});