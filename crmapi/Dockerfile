#See https://aka.ms/containerfastmode to understand how Visual Studio uses this Dockerfile to build your images for faster debugging.

FROM mcr.microsoft.com/dotnet/aspnet:5.0-buster-slim AS base
WORKDIR /app
EXPOSE 30006
ENV ASPNETCORE_URLS=http://+:30006

FROM mcr.microsoft.com/dotnet/sdk:5.0-buster-slim AS build
WORKDIR /src
COPY ["crmapi.csproj", "./"]
RUN dotnet restore "crmapi.csproj"
COPY . .
WORKDIR "/src/."
RUN dotnet build "crmapi.csproj" -c Release -o /app/build

FROM build AS publish
RUN dotnet publish "crmapi.csproj" -c Release -o /app/publish

FROM base AS final
WORKDIR /app
COPY --from=publish /app/publish .
ENTRYPOINT ["dotnet", "crmapi.dll"]