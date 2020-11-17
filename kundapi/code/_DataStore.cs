using System;
using System.Linq;
using System.Collections.Generic;
using System.Collections.Concurrent;
using System.IO;
using System.Threading.Tasks;
using System.Text.Json;
using System.Text.Json.Serialization;
using Microsoft.AspNetCore.Hosting;
using MongoDB.Bson;
using MongoDB.Driver;

namespace kundapi.code
{
    public static class _DataStore
    {
        static ConcurrentDictionary<int, Kund> Kunder;
        static int SenasteKundnr = 0;

        public static void Init(IWebHostEnvironment env)
        {
            Kunder = new ConcurrentDictionary<int, Kund>();
        }

        public static void LaggTillNyKund(Kund kund)
        {
            if (_Config.MongoDbEnabled && SenasteKundnr == 0)
                SenasteKundnr = (int)_MongoDb.GetCount<Kund>();

            kund.Kundnr = System.Threading.Interlocked.Increment(ref SenasteKundnr);

            if (_Config.MongoDbEnabled)
                _MongoDb.InsertOne(kund);
            else
                Kunder.TryAdd(kund.Kundnr, kund);
        }

        public static Kund HamtaKundMedKundnr(int kundnr)
        {
            if (_Config.MongoDbEnabled)
            {
                return ListaKunder().Single(kundapi => kundapi.Kundnr == kundnr);
            }
            else
            {
                var resultat = Kunder.TryGetValue(kundnr, out var kund);

                if (resultat)
                    return kund;

                // TODO: Kontrollera vad som gick fel (exempelvis att ingen kund finns med aktuellt kundnr)
                throw new Exception("HamtaKundMedKundnr: Något gick fel.");
            }
        }

        public static Kund[] HamtaKunderMedPersonnr(string personnr)
        {
            if (_Config.MongoDbEnabled)
            {
                return ListaKunder().Where(kundapi => kundapi.Personnr == personnr).ToArray();
            }
            else
            {
                var resultat = Kunder.Values.Where(kund => kund.Personnr == personnr).ToArray();

                if (resultat.Length > 0)
                    return resultat;

                // TODO: Kontrollera vad som gick fel (exempelvis att ingen kund finns med aktuellt personnr)
                throw new Exception("HamtaKunderMedPersonnr: Något gick fel.");
            }
        }

        public static Kund[] ListaKunder()
        {
            if (_Config.MongoDbEnabled)
                return _MongoDb.GetAll<Kund>().ToArray();
            else
                return Kunder.Values.ToArray();
        }
   }
}