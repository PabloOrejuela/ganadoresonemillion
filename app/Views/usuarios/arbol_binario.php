<link rel="stylesheet" href="<?= site_url(); ?>public/css/arbol-binario.css">
<script src="https://d3js.org/d3.v7.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="col-md-12">
    <svg width="100%" height="100%"></svg>
    <button class="btn btn-outline-primary" id="btn-regresar">Regresar al árbol anterior</button>

    <script>
        const data = <?php 
            $root = $treeData;
            $root['children'] = [];
            echo json_encode($root, JSON_UNESCAPED_UNICODE);
        ?>;

        const todosLosNodos = <?php echo json_encode(array_values($todosLosSocios), JSON_UNESCAPED_UNICODE); ?>;

        // --- Construir árbol n-ario ---
        function construirArbol(nodo, todos) {
            nodo.children = [];
            let hijos = todos.filter(h => String(h.nodopadre) === String(nodo.id));
            hijos.forEach(hijo => {
                nodo.children.push(hijo);
                construirArbol(hijo, todos);
            });
        }

        // --- D3 SVG ---
        const svg = d3.select("svg"),
            width = window.innerWidth,
            height = window.innerHeight;

        const g = svg.append("g").attr("transform", "translate(50,50)");

        const zoom = d3.zoom()
            .scaleExtent([0.5, 2])
            .on("zoom", (event) => g.attr("transform", event.transform));
        svg.call(zoom);

        const rectHeight = 120;
        let stackRaices = [];
        let currentRoot = data;

        // --- Calcular posiciones según posición ---
        function calcularPosiciones(raiz, nivel = 0, x = width / 2) {
            if (!raiz.children || raiz.children.length === 0) {
                raiz._x = x;
                raiz._y = nivel * (rectHeight + 60);
                return;
            }

            const hijosIzq = raiz.children.filter(c => c.posicion == 1);
            const hijosDer = raiz.children.filter(c => c.posicion == 2);
            const espacio = 200;

            hijosIzq.forEach((hijo, i) => {
                calcularPosiciones(hijo, nivel + 1, x - ((hijosIzq.length - i) * espacio));
            });

            hijosDer.forEach((hijo, i) => {
                calcularPosiciones(hijo, nivel + 1, x + ((i + 1) * espacio));
            });

            raiz._x = x;
            raiz._y = nivel * (rectHeight + 60);
        }

        // --- Dibujar árbol ---
        function dibujarArbol(raiz) {
            currentRoot = raiz;
            construirArbol(raiz, todosLosNodos);
            calcularPosiciones(raiz);
            g.selectAll("*").remove();

            const root = d3.hierarchy(raiz);

            // Enlaces tipo T
            g.selectAll(".link")
                .data(root.descendants().slice(1))
                .enter()
                .append("path")
                .attr("class", "link")
                .attr("stroke", "#555")
                .attr("stroke-opacity", 0.5)
                .attr("fill", "none")
                .attr("d", d => {
                    const parentX = d.parent.data._x;
                    const parentY = d.parent.data._y;
                    const childX = d.data._x;
                    const childY = d.data._y;
                    const midY = parentY + rectHeight / (2) ;
                    return `M${parentX},${parentY} V${midY} H${childX} V${childY}`;
                });

            // Nodos
            const node = g.selectAll(".node")
                .data(root.descendants())
                .enter()
                .append("g")
                .attr("class", "node")
                .attr("transform", d => `translate(${d.data._x},${d.data._y})`)
                .on("click", (event, d) => {
                    if (d.data.name) {
                        stackRaices.push(currentRoot);
                        dibujarArbol(d.data);
                    }
                });

            // Rectángulos
            node.append("rect")
                .attr("x", -75)
                .attr("y", -rectHeight / 1.3)
                .attr("width", 150)
                .attr("height", rectHeight)
                .attr("rx", 4)
                .attr("fill", d => d.data.name ? "#e6e9d0" : "transparent")
                .attr("filter", "drop-shadow(2px 2px 2px rgba(0,0,0,0.3))")
                .attr("stroke", d => d.data.name ? "#2E7D32" : "none")
                .attr("stroke-width", d => d.data.name ? 2 : 0);

            // Textos
            node.append("text")
                .attr("x", 0)
                .attr("dy", -60)
                .attr("text-anchor", "middle")
                .attr("dominant-baseline", "middle")
                .style("font-family", "Arial, sans-serif")
                .style("font-weight", "bold")
                .style("font-size", "11px")
                .text(d => d.data.name || "")
                .call(wrapText, 140);

            node.filter(d => d.data.name).append("text")
                .attr("x", 0)
                .attr("dy", -30)
                .attr("text-anchor", "middle")
                .attr("dominant-baseline", "middle")
                .attr("fill", "#000")
                .style("font-size", "10px")
                .text(d => "COD: " + d.data.codigo_socio);

            node.filter(d => d.data.name).append("text")
                .attr("x", 0)
                .attr("dy", -15)
                .attr("text-anchor", "middle")
                .attr("dominant-baseline", "middle")
                .attr("fill", "#000")
                .style("font-size", "10px")
                .text(d => "Rango: " + d.data.rango);

            node.filter(d => d.data.name).append("text")
                .attr("x", 0)
                .attr("dy", -1)
                .attr("text-anchor", "middle")
                .attr("dominant-baseline", "middle")
                .attr("fill", "#000")
                .style("font-size", "10px")
                .text(d => "Estado: " + (d.data.estado == 1 ? "Activo" : "Inactivo"));
        }

        dibujarArbol(data);

        // Botón regresar
        document.getElementById("btn-regresar").addEventListener("click", () => {
            if(stackRaices.length > 0){
                const raizAnterior = stackRaices.pop();
                dibujarArbol(raizAnterior);
            }
        });

        // --- Wrap de texto ---
        function wrapText(textSelection, maxWidth) {
            textSelection.each(function() {
                const textEl = d3.select(this);
                const words = textEl.text().split(/\s+/).reverse();
                let word, line = [], lineNumber = 0;
                const lineHeight = 1.1;
                const dy = parseFloat(textEl.attr("dy")) || 0;

                let tspan = textEl.text(null)
                    .append("tspan")
                    .attr("x", 0)
                    .attr("y", 0)
                    .attr("dy", dy + "px");

                while (word = words.pop()) {
                    line.push(word);
                    tspan.text(line.join(" "));
                    if (tspan.node().getComputedTextLength() > maxWidth) {
                        line.pop();
                        tspan.text(line.join(" "));
                        line = [word];
                        tspan = textEl.append("tspan")
                            .attr("x", 0)
                            .attr("y", 0)
                            .attr("dy", (lineNumber + 1) * lineHeight * 12 + dy + "px")
                            .text(word);
                        lineNumber++;
                    }
                }
            });
        }

        // --- SweetAlert2 ---
        const alertaMensaje = (msg, time, icon) => {
            const toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: time,
                didOpen: (toast) => { toast.onmouseenter = Swal.stopTimer; toast.onmouseleave = Swal.resumeTimer; },
                customClass: { popup: 'popup-class' }
            });
            toast.fire({ position: "top-end", icon: icon, title: msg });
        }
    </script>
</div>
