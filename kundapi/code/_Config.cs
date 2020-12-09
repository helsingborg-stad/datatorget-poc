using System;

namespace kundapi.code
{
    public static class _Config
    {
        public static string OauthAuthority => System.Environment.GetEnvironmentVariable("OAUTH_AUTHORITY") ?? "http://datatorget2.helsingborg.se:30099";
        public static string MessageServiceHost => System.Environment.GetEnvironmentVariable("MESSAGE_SERVICE_HOST") ?? "localhost";
        public static int MessageServicePort => int.Parse(System.Environment.GetEnvironmentVariable("MESSAGE_SERVICE_PORT") ?? "30006");
        public static string MessageServiceUserName => System.Environment.GetEnvironmentVariable("MESSAGE_SERVICE_USERNAME") ?? "datatorget";
        public static string MessageServicePassword => System.Environment.GetEnvironmentVariable("MESSAGE_SERVICE_PASSWORD") ?? "datatorget";
        public static bool MessageServiceEnabled => bool.Parse(System.Environment.GetEnvironmentVariable("MESSAGE_SERVICE_ENABLED") ?? "False");
        public static string MongoDbHost => System.Environment.GetEnvironmentVariable("MONGODB_HOST") ?? "localhost";
        public static int MongoDbPort => int.Parse(System.Environment.GetEnvironmentVariable("MONGODB_PORT") ?? "31002");
        public static string MongoDbUserName => System.Environment.GetEnvironmentVariable("MONGODB_USERNAME") ?? "datatorget";
        public static string MongoDbPassword => System.Environment.GetEnvironmentVariable("MONGODB_PASSWORD") ?? "datatorget";
        public static string MongoDbDatabase => System.Environment.GetEnvironmentVariable("MONGODB_DATABASE") ?? "datatorget";
        public static string MongoDbCollection => System.Environment.GetEnvironmentVariable("MONGODB_COLLECTION") ?? "kunder";
        public static bool MongoDbEnabled => bool.Parse(System.Environment.GetEnvironmentVariable("MONGODB_ENABLED") ?? "False");
    }
}