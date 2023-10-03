# Definindo a imagem base
FROM node:14

# Definindo o diretório de trabalho dentro do container
WORKDIR /app/frontend

# Copiando os arquivos necessários para o container
COPY package.json yarn.lock /app/frontend/

# Instalando as dependências com o Yarn
RUN yarn install

# Definindo variável de ambiente para ambiente de desenvolvimento
ENV NODE_ENV=development

# Copiando o arquivo .env.development para o container, caso seja ambiente de desenvolvimento
# Isso irá sobrescrever o .env criado durante o build para uso com yarn serve
COPY .env.development .env

# Expondo a porta que o aplicativo Vue.js utiliza
EXPOSE 8080

# Comando padrão para iniciar o aplicativo Vue.js com yarn serve
CMD ["yarn", "serve"]
