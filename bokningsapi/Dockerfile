FROM mcr.microsoft.com/dotnet/core/aspnet:3.1 AS base
WORKDIR /app
EXPOSE 30001
ENV ASPNETCORE_URLS=http://+:30001

FROM mcr.microsoft.com/dotnet/core/sdk:3.1 AS build
WORKDIR /src
COPY ["bokningsapi.csproj", "./"]
RUN dotnet restore "bokningsapi.csproj"
COPY . .
WORKDIR "/src/."
RUN dotnet build "bokningsapi.csproj" -c Release -o /app/build

FROM build AS publish
RUN dotnet publish "bokningsapi.csproj" -c Release -o /app/publish

FROM base AS final
WORKDIR /app
COPY --from=publish /app/publish .
COPY config/* config/
ENTRYPOINT ["dotnet", "bokningsapi.dll"]
