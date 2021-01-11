using Grpc.Core;
using Microsoft.Extensions.Logging;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using System.Text.RegularExpressions;

namespace valideringsapi
{
    public class ValideringsService : Validering.ValideringBase
    {
        private readonly ILogger<ValideringsService> _logger;
        public ValideringsService(ILogger<ValideringsService> logger)
        {
            _logger = logger;
        }

        public override Task<ValideringsReply> ValideraEpost(ValideringsRequest request, ServerCallContext context)
        {
            var regex = new Regex(@"^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$");
            return Task.FromResult(new ValideringsReply
            {
                Resultat = regex.IsMatch(request.Str)
            });
        }

        public override Task<ValideringsReply> ValideraPersonnr(ValideringsRequest request, ServerCallContext context)
        {
            var siffror = request.Str.Where(ch => char.IsDigit(ch)).Select(ch => ch - '0').Reverse().ToArray();
            if (siffror.Length == 12)
                siffror = siffror.Take(10).ToArray();

            var status = false;
            if (siffror.Length == 10)
            {
                var summa = 0;
                var mult = 1;
                foreach (var siffra in siffror)
                {
                    var delsumma = siffra * mult;
                    summa += delsumma / 10;
                    summa += delsumma % 10;
                    mult = (mult == 1) ? 2 : 1;
                }
                status = ((summa % 10) == 0) && siffror.Length == 10 || siffror.Length == 12;
            }

            return Task.FromResult(new ValideringsReply
            {
                Resultat = status
            });
        }
    }
}
