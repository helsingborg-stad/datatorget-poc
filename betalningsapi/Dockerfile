FROM mcr.microsoft.com/dotnet/aspnet:5.0 AS base
WORKDIR /app
EXPOSE 30004
ENV ASPNETCORE_URLS=http://+:30004

FROM mcr.microsoft.com/dotnet/sdk:5.0 AS build
WORKDIR /src
COPY ["betalningsapi.csproj", "./"]
RUN dotnet restore "betalningsapi.csproj"
COPY . .
WORKDIR "/src/."
RUN dotnet build "betalningsapi.csproj" -c Release -o /app/build

FROM build AS publish
RUN dotnet publish "betalningsapi.csproj" -c Release -o /app/publish

FROM base AS final
WORKDIR /app
COPY --from=publish /app/publish .
ENTRYPOINT ["dotnet", "betalningsapi.dll"]
