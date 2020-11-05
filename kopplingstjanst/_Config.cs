using System;

namespace kopplingstjanst
{
    public static class _Config
    {
        public static string MessageServiceHost => System.Environment.GetEnvironmentVariable("MESSAGE_SERVICE_HOST") ?? "localhost";
        public static int MessageServicePort => int.Parse(System.Environment.GetEnvironmentVariable("MESSAGE_SERVICE_PORT") ?? "31001");
        public static string MessageServiceUserName => System.Environment.GetEnvironmentVariable("MESSAGE_SERVICE_USERNAME") ?? "datatorget";
        public static string MessageServicePassword => System.Environment.GetEnvironmentVariable("MESSAGE_SERVICE_PASSWORD") ?? "datatorget";
        public static string BetalningsApi => System.Environment.GetEnvironmentVariable("BETALNINGSAPI") ?? "http://localhost:30004/api/v1";
        public static string BokningApi => System.Environment.GetEnvironmentVariable("BOKNINGSAPI") ?? "http://localhost:30001/api/v1";
    }
}