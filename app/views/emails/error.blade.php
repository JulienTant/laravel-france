<div>
    Message :<br />
    <pre>
        {{ $exception->getMessage() }}
    </pre>
</div>

<div>
    Code :<br />
    <pre>
        {{ $exception->getCode() }}
    </pre>
</div>

<div>
    File :<br />
    <pre>
        {{ $exception->getFile() }}
    </pre>
</div>

<div>
    Line :<br />
    <pre>
        {{ $exception->getLine() }}
    </pre>
</div>

<div>
    Trace :<br />
    <pre>
        {{ $exception->getTrace() }}
    </pre>
</div>

<div>
    Trace As String : <br />
    <pre>
        {{ $exception->getTraceAsString() }}
    </pre>
</div>
