using System;
using System.Linq;
using System.Collections.Generic;
using System.Collections.Concurrent;
using System.IO;
using System.Threading.Tasks;
using System.Text.Json;
using System.Text.Json.Serialization;
using Microsoft.AspNetCore.Hosting;

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
            kund.Kundnr = System.Threading.Interlocked.Increment(ref SenasteKundnr);
            var resultat = Kunder.TryAdd(kund.Kundnr, kund);

            if (!resultat)
            {
                // TODO: L�gg till n�gon form av retry-policy
                throw new Exception("LaggTillNyKund: Något gick fel.");
            }
        }

        public static Kund HamtaKundMedKundnr(int kundnr)
        {
            var resultat = Kunder.TryGetValue(kundnr, out var kund);

            if (resultat)
                return kund;

            // TODO: Kontrollera vad som gick fel (exempelvis att ingen kund finns med aktuellt kundnr)
            throw new Exception("HamtaKundMedKundnr: Något gick fel.");
        }

        public static Kund[] HamtaKunderMedPersonnr(string personnr)
        {
            var resultat = Kunder.Values.Where(kund => kund.Personnr == personnr).ToArray();

            if (resultat.Length > 0)
                return resultat;

            // TODO: Kontrollera vad som gick fel (exempelvis att ingen kund finns med aktuellt personnr)
            throw new Exception("HamtaKunderMedPersonnr: Något gick fel.");
        }

        public static Kund[] ListaKunder()
        {
            return Kunder.Values.ToArray();
        }
   }
}