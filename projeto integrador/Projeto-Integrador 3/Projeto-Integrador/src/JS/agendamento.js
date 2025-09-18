document.addEventListener('DOMContentLoaded', function() {
    console.log("✅ Script 'agendamento.js' iniciado.");

    // --- SELETORES DE ELEMENTOS HTML ---
    const calendarioDiv = document.getElementById('calendario');
    const horarioSelect = document.getElementById('horario');
    const dataSelecionadaInput = document.getElementById('data-selecionada');
    const idProfissionalInput = document.getElementById('id-profissional');
    const formAgendamento = document.getElementById('form-agendamento');
    const containerIcones = document.getElementById('profissionais-icones');
    const cardFoto = document.getElementById('profissional-foto');
    const cardNome = document.getElementById('profissional-nome');
    const cardEspecialidade = document.getElementById('profissional-especialidade');
    const servicoContainer = document.getElementById('servico-selecao');
    const radiosValidacao = document.querySelectorAll('input[name="validacao_quimica"]');
    const conteudoAgendamento = document.getElementById('conteudo-agendamento');
    const mensagemValidacao = document.getElementById('mensagem-validacao');
    const idServicoInput = document.getElementById('id-servico');

    // --- VERIFICAÇÃO CRÍTICA ---
    if (!calendarioDiv || !horarioSelect || !formAgendamento || !containerIcones || !cardFoto || !cardNome || !cardEspecialidade) {
        console.error("❌ ERRO CRÍTICO: Um ou mais elementos essenciais do HTML não foram encontrados. Verifique os IDs no arquivo agendamento.php.");
        return; 
    }
    console.log("✅ CHECKPOINT 2: Elementos HTML essenciais encontrados.");

    // --- VARIÁVEIS DE ESTADO ---
    let dataAtual = new Date();
    let profissionaisDisponiveis = [];

    /**
     * FUNÇÃO 1: Busca e renderiza os PROFISSIONAIS.
     */
    async function carregarProfissionais() {
        try {
            const response = await fetch('api_profissionais.php');
            if (!response.ok) throw new Error('Falha ao buscar profissionais');
            
            profissionaisDisponiveis = await response.json();

            if (profissionaisDisponiveis.length > 0) {
                containerIcones.innerHTML = '';
                profissionaisDisponiveis.forEach(prof => {
                    const img = document.createElement('img');
                    img.src = prof.foto_icone_url || 'https://via.placeholder.com/50';
                    img.alt = prof.nome;
                    img.dataset.id = prof.id;
                    containerIcones.appendChild(img);
                });
                selecionarProfissional(profissionaisDisponiveis[0].id);
            } else {
                 containerIcones.innerHTML = "<p style='color: #6C3222;'>Nenhum profissional.</p>";
            }
        } catch (error) {
            console.error("Erro ao carregar profissionais:", error);
        }
    }

    /**
     * FUNÇÃO 2: Atualiza a interface quando um profissional é SELECIONADO.
     */
    function selecionarProfissional(id) {
        const profissionalSelecionado = profissionaisDisponiveis.find(p => p.id == id);
        if (!profissionalSelecionado) return;

        idProfissionalInput.value = profissionalSelecionado.id;
        cardFoto.src = profissionalSelecionado.foto_card_url || 'https://via.placeholder.com/300x400';
        cardNome.textContent = profissionalSelecionado.nome;
        cardEspecialidade.textContent = profissionalSelecionado.especialidade;

        document.querySelectorAll('#profissionais-icones img').forEach(img => {
            img.classList.toggle('active', img.dataset.id == id);
        });

        if (dataSelecionadaInput.value) {
            buscarHorarios(dataSelecionadaInput.value, id);
        } else {
            horarioSelect.innerHTML = '<option value="">Selecione uma data</option>';
        }
    }
    
    /**
     * FUNÇÃO 3: Renderiza o HTML do calendário.
     */
    function renderizarCalendario(data) {
        const ano = data.getFullYear();
        const mes = data.getMonth();
        const hoje = new Date();
        hoje.setHours(0, 0, 0, 0);

        const primeiroDiaDoMes = new Date(ano, mes, 1).getDay();
        const ultimoDiaDoMes = new Date(ano, mes + 1, 0).getDate();
        const nomeMes = data.toLocaleString('pt-BR', { month: 'long' });

        let html = `
            <div class="calendario-header">
                <button type="button" class="nav-btn" id="prev-month"><i class="bi bi-chevron-left"></i></button>
                <span class="mes-ano">${nomeMes.charAt(0).toUpperCase() + nomeMes.slice(1)} ${ano}</span>
                <button type="button" class="nav-btn" id="next-month"><i class="bi bi-chevron-right"></i></button>
            </div>
            <table>
                <thead><tr><th>dom</th><th>seg</th><th>ter</th><th>qua</th><th>qui</th><th>sex</th><th>sab</th></tr></thead>
                <tbody>`;

        let dia = 1;
        for (let i = 0; i < 6; i++) {
            html += '<tr>';
            for (let j = 0; j < 7; j++) {
                if (i === 0 && j < primeiroDiaDoMes) {
                    html += '<td></td>';
                } else if (dia > ultimoDiaDoMes) {
                    html += '<td></td>';
                } else {
                    const dataCompleta = new Date(ano, mes, dia);
                    let classes = (dataCompleta < hoje) ? 'dia-inativo' : 'pode-agendar';
                    if (dia === hoje.getDate() && mes === hoje.getMonth() && ano === hoje.getFullYear()) {
                        classes += ' hoje';
                    }
                    const dataISO = `${ano}-${String(mes + 1).padStart(2, '0')}-${String(dia).padStart(2, '0')}`;
                    html += `<td class="${classes}" data-data="${dataISO}">${dia}</td>`;
                    dia++;
                }
            }
            html += '</tr>';
            if (dia > ultimoDiaDoMes) break;
        }
        html += '</tbody></table>';
        calendarioDiv.innerHTML = html;
        adicionarEventListenersCalendario();
    }
    
    /**
     * FUNÇÃO 4: Adiciona os eventos de clique ao calendário.
     */
    function adicionarEventListenersCalendario() {
        document.getElementById('prev-month').addEventListener('click', () => {
            dataAtual.setMonth(dataAtual.getMonth() - 1);
            renderizarCalendario(dataAtual);
        });

        document.getElementById('next-month').addEventListener('click', () => {
            dataAtual.setMonth(dataAtual.getMonth() + 1);
            renderizarCalendario(dataAtual);
        });

        document.querySelectorAll('.pode-agendar').forEach(td => {
            td.addEventListener('click', (e) => {
                document.querySelectorAll('.dia-selecionado').forEach(el => el.classList.remove('dia-selecionado'));
                e.target.classList.add('dia-selecionado');
                const dataSelecionada = e.target.dataset.data;
                dataSelecionadaInput.value = dataSelecionada;
                const idProfissional = idProfissionalInput.value;
                buscarHorarios(dataSelecionada, idProfissional);
            });
        });
    }

    /**
     * FUNÇÃO 5: Busca os horários disponíveis na API.
     */
    async function buscarHorarios(data, idProfissional) {
        horarioSelect.innerHTML = '<option>Carregando...</option>';
        try {
            const response = await fetch(`api_horarios.php?data=${data}&id_profissional=${idProfissional}`);
            if (!response.ok) throw new Error('Falha na resposta da rede.');
            const horarios = await response.json();
            
            horarioSelect.innerHTML = '';
            if (horarios.length > 0) {
                 horarioSelect.innerHTML = '<option value="">Selecione o horário</option>';
                horarios.forEach(hora => {
                    const option = new Option(hora, hora);
                    horarioSelect.appendChild(option);
                });
            } else {
                horarioSelect.innerHTML = '<option value="">Nenhum horário disponível</option>';
            }
        } catch (error) {
            console.error('❌ Erro ao buscar horários:', error);
            horarioSelect.innerHTML = '<option value="">Erro ao carregar</option>';
        }
    }

    /**
     * FUNÇÃO 6: Lida com a validação da pergunta sobre química.
     */
    radiosValidacao.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'sim') {
                conteudoAgendamento.classList.add('hidden');
                mensagemValidacao.style.display = 'block';
            } else {
                conteudoAgendamento.classList.remove('hidden');
                mensagemValidacao.style.display = 'none';
            }
        });
    });

    /**
     * FUNÇÃO 7: Lida com o envio do formulário.
     */
    formAgendamento.addEventListener('submit', async function(e) {
        e.preventDefault(); 
        
        if (document.getElementById('quimica-sim').checked) {
            alert('Não é possível agendar. Seu cabelo passou por processos químicos recentemente.');
            return;
        }

        const formData = {
            id_profissional: idProfissionalInput.value,
            id_servico: idServicoInput.value,
            data_agendamento: dataSelecionadaInput.value,
            hora_agendamento: horarioSelect.value,
            info_quimica: document.getElementById('quimica_tipo').value
        };

        if (!formData.data_agendamento || !formData.hora_agendamento || !formData.id_servico) {
            alert('Por favor, selecione um serviço, uma data e um horário válidos.');
            return;
        }

        try {
            const response = await fetch('salvar_agendamento.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(formData),
            });
            const resultado = await response.json();
            if (resultado.success) {
                alert(resultado.message);
                location.reload(); 
            } else {
                alert('Erro: ' + resultado.message);
            }
        } catch (error) {
            console.error('Erro ao enviar agendamento:', error);
            alert('Ocorreu um erro de comunicação ao tentar salvar.');
        }
    });

    // --- INICIALIZAÇÃO E EVENT LISTENERS ---
    
    // Ouve o clique nos ícones dos profissionais
    containerIcones.addEventListener('click', function(e) {
        if (e.target.tagName === 'IMG') {
            selecionarProfissional(e.target.dataset.id);
        }
    });

    // Inicia o processo: Primeiro carrega os profissionais, e SÓ DEPOIS, desenha o calendário.
    carregarProfissionais().then(() => {
        renderizarCalendario(dataAtual);
    });
});