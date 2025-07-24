# Build stage
FROM node:20-alpine as builder

WORKDIR /app

COPY package.json .
COPY tsconfig.json .
COPY src ./src

RUN npm install
RUN npm run build

# Run stage
FROM node:20-alpine

WORKDIR /app

COPY --from=builder /app/package.json .
COPY --from=builder /app/dist ./dist

RUN npm install --omit=dev

EXPOSE 3000

CMD ["node", "dist/server.js"]