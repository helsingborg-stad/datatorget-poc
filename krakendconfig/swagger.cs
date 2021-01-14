using System;
using System.Collections.Generic;
using System.Text;
using System.Text.Json;
using System.Linq;

namespace krakendconfig
{
    class Swagger
    {
        JsonDocument document;

        public Swagger(string json)
        {
            document = JsonDocument.Parse(json);
        }

        public string[] GetPaths() => document.RootElement.GetProperty("paths").EnumerateObject().Select(pe => pe.Name).ToArray();
        public string GetMethod(string path) => document.RootElement.GetProperty("paths").GetProperty(path).EnumerateObject().First().Name.ToUpper();
        public string[] GetQueryParams(string path)
        {
            if (document.RootElement.GetProperty("paths").GetProperty(path).EnumerateObject().First().Value.TryGetProperty("parameters", out var e))
                return e.EnumerateArray().Select(pe => pe.GetProperty("name").ToString()).ToArray();
            else
                return new string[0];
        }

        public bool IsArrayResponse(string path)
        {
            if (document.RootElement.GetProperty("paths").GetProperty(path).EnumerateObject().First().Value.GetProperty("responses").GetProperty("200").TryGetProperty("content", out var content))
            {
                if (content.EnumerateObject().First().Value.GetProperty("schema").TryGetProperty("type", out var type) && type.ToString() == "array")
                    return true;
            }
            return false;
        }
    }
}
