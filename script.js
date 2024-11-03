let translations = {};
        const languageSelector = document.getElementById("language-selector");

        // Load translations from JSON file
        fetch('translations.json')
            .then(response => response.json())
            .then(data => {
                translations = data;
                populateLanguageSelector();
                switchLanguage('fr'); // Set default language
            })
            .catch(error => console.error('Error loading translations:', error));

        function populateLanguageSelector() {
            Object.keys(translations).forEach(lang => {
                let option = document.createElement("option");
                option.value = lang;
                option.textContent = lang.toUpperCase();
                languageSelector.appendChild(option);
            });
        }

        function switchLanguage(lang) {
            if (translations[lang]) {
                document.getElementById("doc-title").innerHTML = translations[lang].title;
                document.getElementById("add-component-title").innerHTML = translations[lang].addComponentTitle;
                document.getElementById("intro-text").innerHTML = translations[lang].introText;
                document.getElementById("service-premium-title").innerHTML = translations[lang].servicePremiumTitle;
                document.getElementById("premium-text").innerHTML = translations[lang].premiumText;
                document.getElementById("service-skinapi-title").innerHTML = translations[lang].serviceSkinapiTitle;
                document.getElementById("skinapi-text").innerHTML = translations[lang].skinapiText;
                document.getElementById("integration-instructions-title").innerHTML = translations[lang].integrationInstructionsTitle;
                document.getElementById("instruction-1").innerHTML = translations[lang].instruction1;
                document.getElementById("instruction-2").innerHTML = translations[lang].instruction2;
                document.getElementById("remarks-title").innerHTML = translations[lang].remarksTitle;
                document.getElementById("remarks-text").innerHTML = translations[lang].remarksText;
            }
        }