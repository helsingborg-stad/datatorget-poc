FROM mcr.microsoft.com/dotnet/aspnet:5.0-buster-slim AS base
WORKDIR /app
EXPOSE 30099
ENV ASPNETCORE_URLS=http://+:30099

FROM mcr.microsoft.com/dotnet/sdk:5.0-buster-slim AS build
WORKDIR /src
COPY ["identitysvc.csproj", "./"]
RUN dotnet restore "identitysvc.csproj"
COPY . .
WORKDIR "/src/."
RUN dotnet build "identitysvc.csproj" -c Release -o /app/build

FROM build AS publish
RUN dotnet publish "identitysvc.csproj" -c Release -o /app/publish

FROM base AS final
WORKDIR /app
COPY --from=publish /app/publish .
ENTRYPOINT ["dotnet", "identitysvc.dll"]