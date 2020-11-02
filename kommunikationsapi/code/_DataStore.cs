using System;
using System.Linq;
using System.Collections.Generic;
using System.Collections.Concurrent;
using System.IO;
using System.Threading.Tasks;
using System.Text.Json;
using System.Text.Json.Serialization;
using Microsoft.AspNetCore.Hosting;

namespace kommunikationsapi.code
{
    public static class _DataStore
    {
        static ConcurrentDictionary<string, EpostMeddelande> Meddelanden;

        public static void Init(IWebHostEnvironment env)
        {
            Meddelanden = new ConcurrentDictionary<string, EpostMeddelande>();
        }

        public static void LaggTillNyttMeddelande(EpostMeddelande meddelande)
        {
            var resultat = Meddelanden.TryAdd(meddelande.Id, meddelande);

            if (!resultat)
            {
                // TODO: Lägg till någon form av retry-policy
                throw new Exception("LaggTillNyttMeddelande: Något gick fel.");
            }
        }
   }
}