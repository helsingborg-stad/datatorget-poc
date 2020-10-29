FROM mcr.microsoft.com/dotnet/core/aspnet:3.1 AS base
WORKDIR /app
EXPOSE 30001
ENV ASPNETCORE_URLS=http://+:30002

FROM mcr.microsoft.com/dotnet/core/sdk:3.1 AS build
WORKDIR /src
COPY ["kundapi.csproj", "./"]
RUN dotnet restore "kundapi.csproj"
COPY . .
WORKDIR "/src/."
RUN dotnet build "kundapi.csproj" -c Release -o /app/build

FROM build AS publish
RUN dotnet publish "kundapi.csproj" -c Release -o /app/publish

FROM base AS final
WORKDIR /app
COPY --from=publish /app/publish .
COPY config/* config/
ENTRYPOINT ["dotnet", "kundapi.dll"]
