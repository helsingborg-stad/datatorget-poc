FROM mcr.microsoft.com/dotnet/aspnet:5.0 AS base
WORKDIR /app
EXPOSE 30002
ENV ASPNETCORE_URLS=http://+:30002

FROM mcr.microsoft.com/dotnet/sdk:5.0 AS build
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
ENTRYPOINT ["dotnet", "kundapi.dll"]
