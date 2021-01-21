using System;
using System.Collections.Generic;
using System.Text;
using System.Net.Http;
using System.Linq;
using System.Text.Json;

namespace krakendconfig
{
    class Configurator
    {
        public static string Create()
        {
            var ports = new int[] { 30001, 30002, 30003, 30004, 30006 };
            var swaggerhost = "http://localhost";
            var backendhost = "http://svc-datatorgetbackend";

            var jobj = new
            {
                version = 2,
                extra_config = new
                {
                },
                timeout = "3000ms",
                cache_ttl = "300s",
                output_encoding = "json",
                name = "Datatorget",
                port = "30000",

                endpoints = ports.SelectMany(port => ParseEndpoint(swaggerhost, backendhost, port)).ToArray()
            };

            return JsonSerializer.Serialize(jobj, jobj.GetType(), new JsonSerializerOptions { WriteIndented = true }).Replace("\r\n", "\n");
        }

        private static IEnumerable<object> ParseEndpoint(string swaggerhost, string backendhost, int port)
        {
            var data = GetSwaggerFromUrl(swaggerhost, port);
            var parser = new Swagger(data);

            IEnumerable<object> jobj = parser.GetPaths().Select(path => new { 
                endpoint = path, method = parser.GetMethod(path), output_encoding = "no-op", extra_config = new { },
                backend = new[] { new {
                    url_pattern = path, encoding = "no-op", sd = "static", method = parser.GetMethod(path), disable_host_sanitize = true,
                    extra_config = new { }, host = new[] { $"{backendhost}:{port}" } }
                },
                querystring_params = parser.GetQueryParams(path)
            });

            return jobj;
        }

        private static string ToJson(object obj)
        {
            return JsonSerializer.Serialize(obj, obj.GetType(), new JsonSerializerOptions { WriteIndented = true });
        }

        private static string GetSwaggerFromUrl(string swaggerhost, int port)
        {
            var url = $"{swaggerhost}:{port}/swagger/v1/swagger.json";
            using var client = new HttpClient();
            return client.GetStringAsync(url).Result;
        }
    }
}
