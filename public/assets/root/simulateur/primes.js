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

    primeSouhaite.addEventListener("change", function () {
        const primeValueKds = parseFloat(primeSouhaite.value);
        const produitValueKds = produitCode.value;

        console.log(primeValueKds);
        console.log(produitValueKds);

        if (produitValueKds === "CADENCE") {
            const produitCode = document.getElementById("produitCode").value;
            const primeSouhaite = parseFloat(document.getElementById("primepricipale").value);

            let primes = {
                LIB: { PrimePrincipale: 0, PrimeTheo: 0, FraisAcces: 0, Prime: 0 },
                DIG: { PrimePrincipale: 0, PrimeTheo: 0, Prime: 0 },
                DECESACC: { PrimePrincipale: 0, PrimeTheo: 0, Prime: 0 },
                SUR: { PrimePrincipale: 0, PrimeTheo: 0, Prime: 0 }
            };

            // Boucle sur toutes les garanties
            garantiesProduct.forEach(garantie => {
                const codeGarantie = garantie.codeproduitgarantie;
                
                switch(codeGarantie) {
                    case 'LIB':
                        primes.LIB.PrimePrincipale = primeSouhaite * 0.5;
                        primes.LIB.PrimeTheo = primeSouhaite * 0.5;
                        primes.LIB.FraisAcces = 0;
                        primes.LIB.Prime = primeSouhaite * 0.5;
                        break;
                        
                    case 'DIG':
                        primes.DIG.PrimePrincipale = primeSouhaite * 0.5;
                        primes.DIG.PrimeTheo = primeSouhaite * 0.5;
                        primes.DIG.Prime = primeSouhaite * 0.5;
                        break;
                        
                    case 'DECESACC':
                        primes.DECESACC.PrimePrincipale = primeSouhaite * 0.095;
                        primes.DECESACC.PrimeTheo = primeSouhaite * 0.095;
                        primes.DECESACC.Prime = primeSouhaite * 0.095;
                        break;
                        
                    case 'SUR':
                        // Ajoutez ici la formule pour SUR si nécessaire
                        break;
                        
                    default:
                        console.log(`Garantie non gérée: ${codeGarantie}`);
                }
            });

            console.log('Répartition des primes:', primes);

    

            document.getElementById("display-prime-final").textContent = primeSecu + primePerf;
        }
    });







});



