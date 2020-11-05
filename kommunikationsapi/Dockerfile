FROM mcr.microsoft.com/dotnet/core/aspnet:3.1 AS base
WORKDIR /app
EXPOSE 30003
ENV ASPNETCORE_URLS=http://+:30003

FROM mcr.microsoft.com/dotnet/core/sdk:3.1 AS build
WORKDIR /src
COPY ["kommunikationsapi.csproj", "./"]
RUN dotnet restore "kommunikationsapi.csproj"
COPY . .
WORKDIR "/src/."
RUN dotnet build "kommunikationsapi.csproj" -c Release -o /app/build

FROM build AS publish
RUN dotnet publish "kommunikationsapi.csproj" -c Release -o /app/publish

FROM base AS final
WORKDIR /app
COPY --from=publish /app/publish .
ENTRYPOINT ["dotnet", "kommunikationsapi.dll"]
