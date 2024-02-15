<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <style type="text/css">
        @charset "utf-8";

        body {
            page-break-after: always;
        }

        .w-100 {
            width: 100%;
            text-align: center;
        }

        .info{
            position: relative;
            margin-top: 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid;
        }

        tbody tr{
            text-align: center;
        }

    </style>
</head>

<body>
    <div class="w-100">
        <div>Complexo Escolar Privada Onilka</div>
        <div>I, II Cíclo do Ensino Geral e Técnico Profissional</div>
        <div>Alto-Esperança-Lobito</div>
        <div>{{ $prova->professor_turma->turma->curso->nome }}</div>
    </div>
    <div class="info">
        <div>
            <div>Turma: {{ $prova->professor_turma->turma->chave }} </div>
            <div>Classe: {{ $prova->professor_turma->turma->curso->num_classe }}</div>
            <div>Periódo: {{ $prova->professor_turma->turma->periodo }}</div>
        </div>
        <div style="position: absolute; right:0; top:0;">
            <div>Disciplina: {{ $prova->professor_turma->disciplina->nome }} </div>
            <div>Ano Lectivo: {{ $prova->professor_turma->turma->ano_lectivo->codigo }}</div>
            <div>o (A) Professor (A): {{ $prova->professor_turma->professor->user->name }}</div>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th rowspan="2">nº</th>
                <th rowspan="2">Nome estudante</th>
                <th colspan="4">1º Trimestre</th>
                <th colspan="4">2º Trimestre</th>
                <th colspan="4">3º Trimestre</th>
            </tr>
            <tr>
                <th>MAC1</th>
                <th>NCPP1</th>
                <th>NCPT1</th>
                <th>MT1</th>
                <th>MAC2</th>
                <th>NCPP2</th>
                <th>NCPT2</th>
                <th>MT2</th>
                <th>MAC3</th>
                <th>NCPP3</th>
                <th>NCPT3</th>
                <th>MT3</th>
            </tr>
        </thead>
        <tbody>
            @php
                use App\Http\Controllers\NotaController;
                $notfound = '-';
                $disciplina = $prova->professor_turma->disciplina_id;
                $teacher = $prova->professor_turma->professor_id;
            @endphp
            @foreach ($alunos as $aluno)
                <tr class="tr">
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $aluno->user->name }}</td>

                    <td>{{ $MAC1 = NotaController::getNote('1','EPOCA_1',$disciplina,$aluno->id,$teacher)->valor ??  $notfound }}</td>
                    <td>{{ $NCPP1 = NotaController::getNote('1','EPOCA_2',$disciplina,$aluno->id,$teacher)->valor ?? $notfound }}</td>
                    <td>{{ $NCPT1 = NotaController::getNote('1','EPOCA_3',$disciplina,$aluno->id,$teacher)->valor ?? $notfound }}</td>
                    @php $data = NotaController::media($notfound, $MAC1, $NCPP1, $NCPT1); @endphp
                    <td>{{ $data['allprova'] ? $data['media'] : '-' }}</td>

                    <td>{{ $MAC2 = NotaController::getNote('2','EPOCA_1',$disciplina,$aluno->id,$teacher)->valor ??  $notfound }}</td>
                    <td>{{ $NCPP2 = NotaController::getNote('2','EPOCA_2',$disciplina,$aluno->id,$teacher)->valor ?? $notfound }}</td>
                    <td>{{ $NCPT2 = NotaController::getNote('2','EPOCA_3',$disciplina,$aluno->id,$teacher)->valor ?? $notfound }}</td>
                    @php $data = NotaController::media($notfound, $MAC2, $NCPP2, $NCPT2); @endphp
                    <td>{{ $data['allprova'] ? $data['media'] : '-' }}</td>

                    <td>{{ $MAC3 = NotaController::getNote('3','EPOCA_1',$disciplina,$aluno->id,$teacher)->valor ??  $notfound }}</td>
                    <td>{{ $NCPP3 = NotaController::getNote('3','EPOCA_2',$disciplina,$aluno->id,$teacher)->valor ?? $notfound }}</td>
                    <td>{{ $NCPT3 = NotaController::getNote('3','EPOCA_3',$disciplina,$aluno->id,$teacher)->valor ?? $notfound }}</td>
                    @php $data = NotaController::media($notfound, $MAC3, $NCPP3, $NCPT3); @endphp
                    <td>{{ $data['allprova'] ? $data['media'] : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
