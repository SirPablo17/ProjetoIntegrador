            
        function CPF(campo) {
            let v = campo.value.replaceAll('.', '').replaceAll('-', '');      
            if (v.length > 3) v = v.substring(0, 3) + '.' + v.substring(3);
            if (v.length > 7) v = v.substring(0, 7) + '.' + v.substring(7);
            if (v.length > 11) v = v.substring(0, 11) + '-' + v.substring(11, 13);
            campo.value = v;
        };

        function TEL(campo){
            let v = campo.value.replace(/\D/g, '');
            if (v.length > 2) v = '(' + v.slice(0, 2) + ') ' + v.slice(2);
            if (v.length > 7) v = v.slice(0, 10) + '-' + v.slice(10, 14);
            campo.value = v;
        };

        function CEP(campo) {
            let v = campo.value.replaceAll('-', '');
            if (v.length > 5) v = v.slice(0, 5) + '-' + v.slice(5, 8);
            campo.value = v;
        };
