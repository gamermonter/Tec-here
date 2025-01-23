import cv2
import face_recognition
import mysql.connector
import numpy as np
from flask import Flask, render_template, Response

# Criação de uma aplicação Flask
app = Flask(__name__)

# Conecta ao banco de dados MySQL para buscar informações dos alunos
conexao = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="techere" 
)

cursor = conexao.cursor()

# Busca o ID, nome e foto de todos os alunos
cursor.execute("SELECT id, nome, foto FROM aluno")
pessoas_db = cursor.fetchall()


# Cria listas para armazenar os dados de identificação facial (codificações) e nomes
codificacoes_face_db = []
nomes_db = []
for aluno_id, nome, foto in pessoas_db:
    # Carrega a foto do aluno e cria uma "codificação facial" única
    imagem = face_recognition.load_image_file(foto)
    codificacao_face = face_recognition.face_encodings(imagem)
    if codificacao_face:
        codificacoes_face_db.append(codificacao_face[0])
        nomes_db.append((nome, aluno_id))

# Atualiza o banco de dados para indicar que o aluno está presente
def marcar_presenca(aluno_id):
    sql = "UPDATE aluno SET presente = 1 WHERE id = %s"
    cursor.execute(sql, (aluno_id, ))
    conexao.commit()


# Ativa a câmera para capturar o vídeo ao vivo
video_capture = cv2.VideoCapture(0)
if not video_capture.isOpened():  # Verifica se a câmera abriu corretamente
    print("Erro ao acessar a câmera!")
    exit()

# Função que captura os frames da câmera e processa os rostos
def gerar_frames():
    while True:
        # Captura o vídeo frame por frame
        ret, frame = video_capture.read()
        if not ret:
            print("Erro ao capturar o frame. Tentando novamente...")
            continue

        # Converte a imagem de BGR (padrão OpenCV) para RGB (necessário para reconhecimento facial)
        rgb_frame = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)

        # Localiza os rostos e gera codificações para cada rosto no frame
        face_locations = face_recognition.face_locations(rgb_frame)
        face_encodings = face_recognition.face_encodings(rgb_frame, face_locations)

        # Processa cada rosto detectado
        for (top, right, bottom, left), face_encoding in zip(face_locations, face_encodings):
            # Compara os rostos capturados com os rostos no banco de dados
            matches = face_recognition.compare_faces(codificacoes_face_db, face_encoding)
            nome = "Desconhecido"  # Nome padrão se o rosto não for reconhecido
            aluno_id = None

            # Se um rosto for reconhecido
            if True in matches:
                match_index = np.argmin(face_recognition.face_distance(codificacoes_face_db, face_encoding))
                nome, aluno_id = nomes_db[match_index]  # Obtém o nome e ID do aluno correspondente

                # Marca a presença do aluno no banco de dados
                if aluno_id is not None:
                    marcar_presenca(aluno_id)

            # Desenha um retângulo ao redor do rosto e exibe o nome
            cv2.rectangle(frame, (left, top), (right, bottom), (0, 255, 0), 2)
            cv2.putText(frame, nome, (left, top - 10), cv2.FONT_HERSHEY_SIMPLEX, 0.6, (0, 255, 0), 2)

        # Codifica o frame como imagem JPEG para enviar ao navegador
        ret, buffer = cv2.imencode('.jpg', frame)
        frame = buffer.tobytes()

        # Envia o frame para o navegador como uma resposta de vídeo
        yield (b'--frame\r\n'
               b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n\r\n')


# Renderiza a página inicial
@app.route('/')
def index():
    return render_template('chamada.php')

# Envia os frames gerados pela câmera ao navegador
@app.route('/video_feed')
def video_feed():
    return Response(gerar_frames(), mimetype='multipart/x-mixed-replace; boundary=frame')

# Inicia o aplicativo Flask para permitir o acesso pela rede
if __name__ == '__main__':  
    app.run(debug=True, host='0.0.0.0', port=5000)

# Fecha a conexão com o banco de dados ao final do código
cursor.close()
conexao.close()
